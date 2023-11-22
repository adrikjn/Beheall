<?php
# api/src/State/UserPasswordHasher.php
namespace App\State;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

// Classe responsable du hachage du mot de passe utilisateur avant la persistence des données.
final class UserPasswordHasher implements ProcessorInterface
{
    // Constructeur
    public function __construct(private readonly ProcessorInterface $processor, private readonly UserPasswordHasherInterface $passwordHasher)
    {
    }

    // Traite les données avant la persistence.
    public function process($data, Operation $operation, array $uriVariables = [], array $context = [])
    {
        //  Si le mot de passe brut n'est pas fourni, utilise le processeur d'état sans modification.
        if (!$data->getPlainPassword()) {
            return $this->processor->process($data, $operation, $uriVariables, $context);
        }

        // Hache le mot de passe brut et met à jour l'entité utilisateur.
        $hashedPassword = $this->passwordHasher->hashPassword(
            $data,
            $data->getPlainPassword()
        );

        $data->setPassword($hashedPassword);
        $data->eraseCredentials();

        // Passe le contrôle au processeur d'état sous-jacent.
        return $this->processor->process($data, $operation, $uriVariables, $context);
    }
}
