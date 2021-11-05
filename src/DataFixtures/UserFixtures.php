<?php

namespace App\DataFixtures;

use Faker;
use App\Entity\User;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
    private $encoder;
    public function __construct(UserPasswordHasherInterface $encoder ){
        $this->encoder = $encoder;
    }
    public function load(ObjectManager $manager): void
    {
       $faker = Faker\Factory::create('fr_FR');
       for($nbreUser = 1; $nbreUser<10; $nbreUser++){
           $user = new User;
           $user->setEmail($faker->email);
                $user->setRoles(['ROLE_USER']);
                $user->setPassword($this->encoder->hashPassword($user, 'azerty'));
                $user->setName($faker->firstName);
                $manager->persist($user);

            //enregister la categorie dans une reference
            $this->addReference('user_'. $nbreUser, $user);
           }
       
        $manager->flush();
    }
}
