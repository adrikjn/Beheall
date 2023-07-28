<?php

namespace App\DataFixtures;

use App\Entity\User;
use App\Entity\Services;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{

    public function __construct(private UserPasswordHasherInterface $hasher)
    {
    }

    public function load(ObjectManager $manager): void
    {
        for ($i = 1; $i <= 50; $i++) {
            $user = new User();
            $user->setEmail("user$i@example.com");
            $user->setRoles(['ROLE_USER']);
            $password = $this->hasher->hashPassword($user, 'Azerty*123');
            $user->setPassword($password);
            $user->setLastName("Lastname $i");
            $user->setFirstName("Firstname $i");
            $user->setPhoneNumber("123456789$i");

            $manager->persist($user);
        }
        $manager->flush();




       
    }
}
