<?php

namespace App\EventListener;

use Lexik\Bundle\JWTAuthenticationBundle\Event\AuthenticationSuccessEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use App\Entity\User;

class JwtClaimsSubscriber implements EventSubscriberInterface
{
    public function onAuthenticationSuccess(AuthenticationSuccessEvent $event)
    {
        $user = $event->getUser();

        if (!$user instanceof User) {
            return;
        }

        // Ajouter l'ID de l'utilisateur au payload du JWT
        $payload = $event->getData();
        $payload['userId'] = $user->getId();

        $event->setData($payload);
    }

    public static function getSubscribedEvents()
    {
        return [
            'lexik_jwt_authentication.on_authentication_success' => 'onAuthenticationSuccess',
        ];
    }
}
