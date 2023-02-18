<?php

namespace App\Service;


use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

class MailerService
{
    public function __construct(MailerInterface $mailer)
    {
        $this->mailer = $mailer;
    }

    public function sendEmail(

        $nom = '',
        $prenom = '',
        $text = '',
        $mail= '',
        $telephone = '',

    ): void
    {
        $email = (new Email())
            ->from('exemple1@foo.com')
            ->to('exemple2@foo.com')
            //->cc('cc@example.com')
            //->bcc('bcc@example.com')
            //->replyTo('fabien@example.com')
            //->priority(Email::PRIORITY_HIGH)
            ->subject($nom.' '.$prenom.' '.'vous a envoyé un mail!')
            //->text($text);
            ->html("
                    <div>
                        <p>$nom $prenom vous a envoyé un mail!</p>
                        <p>Voici son mail: $mail</p>
                        <p>Et son numéro de téléphone: $telephone pour le contacter !</p>
                 
                    </div>                    
                    
                    <div>
                        <p>Voici le contenu du message: </p>
                        <p>$text</p>
                    </div>
                    
                    ");

        $this->mailer->send($email);

    }
}