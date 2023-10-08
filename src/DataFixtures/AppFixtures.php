<?php

namespace App\DataFixtures;

use App\Entity\Service;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);
        $servicesMedical = [
            'Accueil',
            'Laboratoir',
            'Consultation'
        ];

        foreach ($servicesMedical as $s) {
            $service = new Service();
            $service->setNom($s);
            $manager->persist($service);
        }

        $manager->flush();
    }
}
