<?php

namespace App\Twig\Components;

use App\Repository\PatientRepository;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;
use Symfony\UX\LiveComponent\DefaultActionTrait;
use Symfony\UX\LiveComponent\Attribute\LiveProp;

#[AsLiveComponent()]
final class ListUserHome
{
    use DefaultActionTrait;

    #[LiveProp(writable: true)]
    public string $query = '';

    public function __construct(private PatientRepository $patientRepository)
    {
        
    }

    public function getPatients()
    {
        if ( trim($this->query) != '') 
        {
            return $this->patientRepository->search($this->query);
        }
        return $this->patientRepository->findBy([],['id' => 'DESC'], 10);
    }
}
