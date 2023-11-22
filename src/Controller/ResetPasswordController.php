<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Component\Mime\Email;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Csrf\TokenGenerator\TokenGeneratorInterface;

// Contrôleur responsable de la réinitialisation du mot de passe.
class ResetPasswordController extends AbstractController
{
    private $entityManager; // Déclarez une propriété privée pour l'EntityManager

    public function __construct(EntityManagerInterface $entityManager) // Injectez l'EntityManager
    {
        $this->entityManager = $entityManager;
    }

    // Confirme la réinitialisation du mot de passe en utilisant le token.
    /**
     * @Route("/reset-password/confirm/{token}", name="reset_password_confirm", methods={"GET", "POST"})
     */
    public function confirmResetPassword(Request $request, string $token, UserPasswordHasherInterface $passwordHasher): Response
    {
        // Récupère l'utilisateur associé au token depuis la base de données.
        $user = $this->entityManager->getRepository(User::class)->findOneBy(['resetPasswordToken' => $token]);

        // Vérifie si l'utilisateur existe.
        if (!$user) {
            throw $this->createNotFoundException('Utilisateur non trouvé');
        }

        // Vérifie si la requête est de type POST (soumission du formulaire).
        if ($request->isMethod('POST')) {
            // Récupère les nouveaux mots de passe depuis la requête.
            $newPassword = $request->request->get('password');
            $confirmPassword = $request->request->get('confirm_password');

            // Vérifie si les mots de passe correspondent.
            if ($newPassword === $confirmPassword) {
                // Hache et met à jour le mot de passe de l'utilisateur.
                $hashedPassword = $passwordHasher->hashPassword($user, $newPassword);
                $user->setPassword($hashedPassword);
                $user->setResetPasswordToken(null);

                // Enregistre les modifications dans la base de données.
                $this->entityManager->persist($user);
                $this->entityManager->flush();
            }
        }

        // Affiche la vue de confirmation avec le token.
        return $this->render('reset_password/confirm.html.twig', [
            'token' => $token,
        ]);
    }

    // Réinitialise le mot de passe et envoie un e-mail avec le lien de réinitialisation.
    /**
     * @Route("/reset-password", name="reset_password", methods={"POST"})
     */
    public function resetPassword(Request $request, MailerInterface $mailer, UserRepository $userRepository, TokenGeneratorInterface $tokenGenerator, UserPasswordHasherInterface $passwordHasher): Response
    {
        // Récupère l'adresse e-mail depuis les données de la requête JSON.
        $data = json_decode($request->getContent(), true);
        $email = $data['email'];

        // Recherchez l'utilisateur par son email
        $user = $userRepository->findOneBy(['email' => $email]);

        // Vérifie si l'utilisateur existe.
        if (!$user) {
            return new JsonResponse(['message' => 'Utilisateur non trouvé.'], Response::HTTP_NOT_FOUND);
        }

        // Générez un jeton unique pour réinitialiser le mot de passe
        $token = $tokenGenerator->generateToken();

        // Stockez le token dans l'entité User
        $user->setResetPasswordToken($token);

        // Enregistrez les modifications dans la base de données en utilisant l'EntityManager
        $this->entityManager->flush();

        // Envoyez un e-mail à l'utilisateur avec le lien de réinitialisation
        $resetUrl = $this->generateUrl('reset_password_confirm', ['token' => $token], UrlGeneratorInterface::ABSOLUTE_URL);

        // Crée et envoie l'e-mail de réinitialisation.
        $email = (new Email())
            ->from('beheallpro@outlook.com')
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
