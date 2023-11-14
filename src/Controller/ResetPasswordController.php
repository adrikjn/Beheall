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


class ResetPasswordController extends AbstractController
{
    private $entityManager; // Déclarez une propriété privée pour l'EntityManager

    public function __construct(EntityManagerInterface $entityManager) // Injectez l'EntityManager
    {
        $this->entityManager = $entityManager;
    }
     /**
     * @Route("/reset-password/confirm/{token}", name="reset_password_confirm", methods={"GET", "POST"})
     */
    public function confirmResetPassword(Request $request, string $token, UserPasswordHasherInterface $passwordHasher): Response
    {
        $user = $this->entityManager->getRepository(User::class)->findOneBy(['resetPasswordToken' => $token]);

        if (!$user) {
            throw $this->createNotFoundException('Utilisateur non trouvé');
        }

        if ($request->isMethod('POST')) {
            $newPassword = $request->request->get('password');
            $confirmPassword = $request->request->get('confirm_password');

            if ($newPassword === $confirmPassword) {
                $hashedPassword = $passwordHasher->hashPassword($user, $newPassword);
                $user->setPassword($hashedPassword);
                $user->setResetPasswordToken(null);

                $this->entityManager->persist($user);
                $this->entityManager->flush();

                return $this->redirectToRoute('www.beheall.com');
            }
        }

        return $this->render('reset_password/confirm.html.twig', [
            'token' => $token,
        ]);
    }

    /**
     * @Route("/reset-password", name="reset_password", methods={"POST"})
     */
    public function resetPassword(Request $request, MailerInterface $mailer, UserRepository $userRepository, TokenGeneratorInterface $tokenGenerator, UserPasswordHasherInterface $passwordHasher): Response
    {
        $data = json_decode($request->getContent(), true);
        $email = $data['email'];
    
        // Recherchez l'utilisateur par son email
        $user = $userRepository->findOneBy(['email' => $email]);
    
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
