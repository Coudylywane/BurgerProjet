<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
    public function __construct(private UserPasswordHasherInterface $hasher){}

    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);

        //$manager->flush();

        $roles=["ROLE_USER","ROLE_GESTIONNAIRE"];
      
            $gestionnaire = new User();
            $gestionnaire->setNom('coudy');
            $gestionnaire->setPrenom('wane');
            $gestionnaire->setEmail("coudy@gmail.com");
            $gestionnaire->setPassword($this->hasher->hashPassword($gestionnaire, 'passer@123'));
            $gestionnaire->setTelephone('781719525');
            $gestionnaire->setRoles(['ROLE_GESTIONNAIRE']);

            $manager->persist($gestionnaire);


            $user = new User();
            $user->setNom('co');
            $user->setPrenom('wane');
            $user->setEmail("co@gmail.com");
            $user->setPassword($this->hasher->hashPassword($user, 'passer@123'));
/*             $user->setPassword('passer@123');
 */            $user->setTelephone('781719525');
            $user->setRoles(['ROLE_USER']);

            $manager->persist($user);

           
        
 
            $manager->flush();
    }

   
        

}
