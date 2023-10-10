<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class ResetPasswordController extends AbstractController
{
    /**
     * @Route("/reset-password/confirm/{token}", name="reset_password_confirm")
     */
    public function confirmResetPassword(string $token): Response
    {
        // Vérifiez le jeton et effectuez la réinitialisation du mot de passe ici.
        // Vous pouvez également afficher un formulaire de réinitialisation de mot de passe.

        return $this->render('reset_password/confirm.html.twig', [
            'token' => $token,
        ]);
    }

    /**
     * @Route("/reset-password", name="reset_password", methods={"POST"})
     */
    public function resetPassword(Request $request, MailerInterface $mailer): Response
    {
        $data = json_decode($request->getContent(), true);
        $email = $data['email'];

        // Générez un jeton unique (par exemple, une chaîne aléatoire)
        $token = bin2hex(random_bytes(32));

        // Envoyez un e-mail à l'utilisateur avec le lien de réinitialisation
        $resetUrl = $this->generateUrl('reset_password_confirm', ['token' => $token], UrlGeneratorInterface::ABSOLUTE_URL);

        // Utilisez SendinBlue pour envoyer l'e-mail
        $email = (new Email())
            ->from('beheallpro@outlook.com') // Mettez votre adresse e-mail d'expéditeur
            ->to($email)
            ->subject('Réinitialisation de mot de passe')
            ->html(
                $this->renderView(
                    'reset_password/index.html.twig',
                    ['resetUrl' => $resetUrl]
                )
            );

        $mailer->send($email);

        return new Response('E-mail de réinitialisation envoyé avec succès !');
    }
}
