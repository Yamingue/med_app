<?php

namespace App\DataFixtures;

use App\Entity\Service;
use App\Entity\TypeConsultation;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        
        $servicesMedical = [
            'Accueil',
            'Laboratoir',
            'Consultation'
        ];

        $consultation_type = [
            'Consultation générale',
            'Suivi post-opératoire',
            'Examen de routine'
        ];

        foreach ($servicesMedical as $s) {
            $service = new Service();
            $service->setNom($s);
            $manager->persist($service);
        }
        foreach ($consultation_type as $s) {
            $type = new TypeConsultation();
            $type->setNom($s);
            $manager->persist($type);
        }

        $manager->flush();
    }
}
