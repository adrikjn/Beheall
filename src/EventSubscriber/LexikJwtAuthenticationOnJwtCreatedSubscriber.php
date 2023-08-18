<?php

namespace App\EventSubscriber;

use Lexik\Bundle\JWTAuthenticationBundle\Event\JWTCreatedEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Security\Core\User\UserInterface;


class JwtCreatedSubscriber implements EventSubscriberInterface
{
    public function onJwtCreated(JWTCreatedEvent $event)
    {
        $user = $event->getUser();

        if (!$user instanceof UserInterface) {
            return;
        }

        // Ajouter des informations supplémentaires au payload du JWT
        $payload = $event->getData();
        $payload['userId'] = $user->getId();
        // ...

        $event->setData($payload);
    }

    public static function getSubscribedEvents()
    {
        return [
            'lexik_jwt_authentication.on_jwt_created' => 'onJwtCreated',
        ];
    }
}
