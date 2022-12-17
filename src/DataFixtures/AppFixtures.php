<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{

    public function __construct(private UserPasswordHasherInterface $userPasswordHasher)
    {

    }

    public function load(ObjectManager $manager): void
    {
        for ($i = 0; $i <= 10; $i++) {

            $user = new User();
            $user->setEmail('user' . $i . '@gmail.com');
            $user->setRoles(["USER"]);
            $user->setPassword($this->userPasswordHasher->hashPassword($user, 'password'));

            $manager->persist($user);
        }

        $admin = new User();
        $admin->setEmail('admin@gmail.com');
        $admin->setRoles(["ADMIN"]);
        $admin->setPassword($this->userPasswordHasher->hashPassword($user, 'password'));

        $manager->persist($user);
        $manager->persist($admin);


        $manager->flush();
    }
}
