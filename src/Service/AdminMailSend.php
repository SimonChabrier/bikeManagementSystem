<?php

namespace App\Service;

use Symfony\Component\Mime\Email;
use Symfony\Component\Mailer\MailerInterface;

class AdminMailSend
{
    /**
     * Send a mail to the administrator if a new user creates an account
     * 
     * @param MailerInterface $mailer
     * @return void
     */
    public function informAdminNewUserCreated(MailerInterface $mailer): void
    {
        $new_user_register = (new Email())
        ->from('simonchabrier@gmail.com') // for mailTrap you can use any fake mail here
        ->to('simonchabrier@gmail.com') // for mailTrap you can use any fake mail here
        ->subject('Nouvel utilisateur') 
        ->text('Un nouvel utilisateur vient de créer un compte !'); 
        $mailer->send($new_user_register);
    }

}