<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{

    public function __construct(private UserPasswordHasherInterface $hasher)
    {
    }

    public function load(ObjectManager $manager): void
    {
        $user = new User();
        $user->setEmail('admin@gmail.com');
        $user->setFirstName('Admin');
        $user->setLastName('Admin');
        $user->setPhoneNumber('06 06 06 06 06');
        $user->setRoles([
            'ROLE_ADMIN',
            'ROLE_USER'
        ]);
        $password = $this->hasher->hashPassword($user, 'Admin123@');
        $user->setPassword($password);

        $manager->persist($user);

        $manager->flush();
    }
}
