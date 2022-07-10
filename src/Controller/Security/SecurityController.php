<?php

namespace App\Controller\Security;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    /**
     * @Route("/login", name="app_login")
     */
    public function login(AuthenticationUtils $authenticationUtils, Request $request): Response
    {   
        // We create a custom redirection for user on last url visited before login action
        // Here, we get the url user comes from.
        $targetOrigin = $request->headers->get('referer');

        if ($targetOrigin){

        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig',[
            'last_username' => $lastUsername,
            'error' => $error,
            'custom_redirection' => $targetOrigin,
            ]);
            
        } else {
 
            $error = $authenticationUtils->getLastAuthenticationError();
            $last_username = $authenticationUtils->getLastUsername();

            return $this->render('security/login.html.twig', [
                'last_username' => $last_username,
                'error' => $error,
            ]);
        }    
    }

    /**
     * @Route("/logout", name="app_logout")
     */
    public function logout(): void
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }
}
