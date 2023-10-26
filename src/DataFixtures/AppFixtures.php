<?php

namespace App\DataFixtures;

use App\Entity\Service;
use App\Entity\TypeConsultation;
use App\Entity\User;
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

        $user = new User();
        $user->setUsername('root');
        $user->setPassword('$2y$13$CzjaWc6/VDMNNDLVGMPxQ.tKrnF1JFjKWGUsmkGrurc51zFqbxh.y');
        $user->setRoles(['ROLE_ADMIN']);
        $user->setGenre('M');
        $user->setCivilite('Mr');
        $user->setNom('Admin');
        $user->setPrenom('Admin');
        $manager->persist($user);

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
