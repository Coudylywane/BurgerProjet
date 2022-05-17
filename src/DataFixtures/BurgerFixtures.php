<?php

namespace App\DataFixtures;

use App\Entity\Burger;
use App\Entity\Commande;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class BurgerFixtures extends Fixture
{


    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);

        for ($i = 1; $i <=10; $i++) {
            $burger = new Burger();
            $burger->setNomBurger('Burger '.$i);
            $burger->setPrixBurger(1500);
            $burger->setDescription('description');
            $manager->persist($burger);
        }

        $manager->flush();
    }

    
}
