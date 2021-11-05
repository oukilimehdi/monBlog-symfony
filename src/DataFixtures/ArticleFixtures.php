<?php

namespace App\DataFixtures;

use Faker;
use DateTime;
use App\Entity\Article;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class ArticleFixtures extends Fixture
{
    
    public function load(ObjectManager $manager): void
    {
       $faker = Faker\Factory::create('fr_FR');
       for($nbreArticle = 1; $nbreArticle<50; $nbreArticle++){
            $user = $this->getReference('user_'. $faker->numberBetween(1,9));
            $categorie = $this->getReference('categorie_'. $faker->numberBetween(1, 5));


            $article = new Article;
            $article->setUser($user);
            $article->setCategory($categorie);
            $article->setTitle($faker->realText(25));
            $article->setSubtitle($faker->realText(90));
            $article->setContent($faker->realText(400));
            $manager->persist($article);
       }

        $manager->flush();
    }
}
