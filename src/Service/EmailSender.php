<?php 

namespace App\Service;

use App\Entity\User;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;

/**
 * Service chargé de créer et d'envoyer des emails
 */
class EmailSender
{
    private $mailer;

    public function __construct(MailerInterface $mailer)
    {
        $this->mailer = $mailer;
    }

    /**
     * Créer un email préconfiguré
     * @param string $subject   Le sujet du mail
     */
    private function createTemplatedEmail(string $subject): TemplatedEmail
    {
        return (new TemplatedEmail())
            ->from(new Address('ikaba49@gmail.com', 'Ibrahim'))  # Expéditeur
            ->subject("\u{1F3A7} Kritik | $subject")            # Objet du mail
        ;
    }

    /**
     * Envoyer un email de confirmation de compte suite à l'inscription
     * @param User $user    L'utilisateur devant confirmer son compte
     */
    public function sendAccountConfirmationEmail(User $user): void
    {
        $email = $this->createTemplatedEmail('Confirmation de compte')
            ->to(new Address($user->getEmail(), $user->getPseudo()))    # Déstinataire
            ->htmlTemplate('email/account_confirmation.html.twig')      # Template twig du meesage
            ->context([
                'user' => $user,
            ])
        ;

        // Envoi de l'email
        $this->mailer->send($email);
    }
}