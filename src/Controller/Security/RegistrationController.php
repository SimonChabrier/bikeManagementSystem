<?php

namespace App\Controller\Security;

use App\Entity\User;
use App\Security\EmailVerifier;
use App\Service\AdminMailSend;
use App\Form\RegistrationFormType;
use App\Repository\UserRepository;
use App\Security\UserAuthenticator;
use Symfony\Component\Mime\Address;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use SymfonyCasts\Bundle\VerifyEmail\Exception\VerifyEmailExceptionInterface;
use Symfony\Component\Security\Http\Authentication\UserAuthenticatorInterface;

class RegistrationController extends AbstractController
{
    private EmailVerifier $emailVerifier;

    public function __construct(EmailVerifier $emailVerifier)
    {
        $this->emailVerifier = $emailVerifier;
    }

    /**
     * @Route("/register", name="app_register")
     */
    public function register(Request $request,
    UserPasswordHasherInterface $userPasswordHasher,
    UserAuthenticatorInterface $userAuthenticator,
    UserAuthenticator $authenticator,
    EntityManagerInterface $entityManager,
    AdminMailSend $adminmail,
    MailerInterface $mailer ): Response
    {
        $user = new User();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);
    
        if ($form->isSubmitted() && $form->isValid()) {

            if ($form->get('job')->getData() === 'administrateur') {
                $user->setRoles(['ROLE_ADMINISTRATEUR']);
                //need SUPER_ADMIN validation to be fully activated
                $user->setStatus(false);
            } 

            if ($form->get('job')->getData() === 'moniteur') {
                $user->setRoles(['ROLE_MONITEUR']) ;
            } 

            if ($form->get('job')->getData() === 'partenaire') {
                $user->setRoles(['ROLE_PARTENAIRE']) ;
            } 

            if ($form->get('job')->getData() === 'travailleur') {
                $user->setRoles(['ROLE_TRAVAILLEUR']) ;
            } 

            

            // encode the plain password
            $user->setPassword(
            $userPasswordHasher->hashPassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );
    
            $entityManager->persist($user);
            $entityManager->flush();

            // generate a signed url and email it to the user
            $this->emailVerifier->sendEmailConfirmation('app_verify_email', $user,
            // here we use the template registration/confirmation_email.html.twig 
                (new TemplatedEmail())
                    ->from(new Address('simonchabrier@gmail.com', 'myStarterPack')) // for mail trap use a fake mail here
                    ->to($user->getEmail())
                    ->subject('Please Confirm your Email')
                    ->htmlTemplate('registration/confirmation_email.html.twig')
            );
           
            // do anything else you need here, like send an email
            //* eg if you need to know new user register personalize this in src/Service/AdminMailSend.php :

            $adminmail->informAdminNewUserCreated($mailer);

            //* for use gmail make the command : composer require symfony/google-mailer 
            //* and configure Gmail to authorize the use of third party application :
            //* https://support.google.com/a/answer/6260879?hl=fr#:~:text=Vous%20pouvez%20autoriser%20ou%20non,%40gmail.com%22
            //* Finally, update your env.local with : MAILER_DSN=gmail://monmail@gmail.com:MotdePasseSpécialFourniParGmail@default?verify_peer=0

            // autologin after registration
            return $userAuthenticator->authenticateUser(
                $user,
                $authenticator,
                $request
            );
        }

        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }

    /**
     * @Route("/verify/email", name="app_verify_email")
     */
    public function verifyUserEmail(Request $request,
    TranslatorInterface $translator,
    UserRepository $userRepository ): Response
    {
        $id = $request->get('id');

        if (null === $id) {
            return $this->redirectToRoute('app_register');
        }

        $user = $userRepository->find($id);

        if (null === $user) {
            return $this->redirectToRoute('app_register');
        }
        
        try {
            $this->emailVerifier->handleEmailConfirmation($request, $user); 
            // validate email confirmation link, sets User::isVerified=true and persists
        } catch (VerifyEmailExceptionInterface $exception) {
            $this->addFlash('verify_email_error', $translator->trans($exception->getReason(), [], 'VerifyEmailBundle'));
            return $this->redirectToRoute('app_register');
        }

        // Redirect User after email verification + flash message
        $this->addFlash('isVerified', 'Votre email est bien vérifié !');
        return $this->redirectToRoute('app_home');
    }
}
