<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

// Contrôleur responsable de la gestion de la sécurité, y compris la connexion et la déconnexion.
class SecurityController extends AbstractController
{
    // Affiche le formulaire de connexion.
    #[Route(path: '/login-to-access-to-dashboard-921684967951697', name: 'app_login')]
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // Décommentez la section ci-dessous si vous souhaitez rediriger les utilisateurs connectés.
        // if ($this->getUser()) {
        //     return $this->redirectToRoute('target_path');
        // }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        // Affiche la vue du formulaire de connexion avec les données nécessaires.
        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

    // Déconnecte l'utilisateur.
    #[Route(path: '/logout', name: 'app_logout')]
    public function logout(): void
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }
}
