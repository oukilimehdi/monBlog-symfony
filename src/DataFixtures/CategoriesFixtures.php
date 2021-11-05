<?php

namespace App\DataFixtures;

use App\Entity\Category;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class CategoriesFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $categories = [
            1 => [
                'name' => 'foot-ball'
            ],
            2=> [
                'name' => 'cinéma'
            ],
            3=> [
                'name' => 'immobilier'
            ],
            4=> [
                'name' => 'développement web'
            ],
            5=> [
                'name' => 'php'
            ],
        ];

        foreach ($categories as $key => $value){
            $categorie = new Category;
            $categorie->setName($value['name']);
            $manager->persist($categorie);

            //enregister la categorie dans une reference
            $this->addReference('categorie_'. $key, $categorie);
        }

        $manager->flush();
    }
    
}
