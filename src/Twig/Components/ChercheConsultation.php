<?php

namespace App\Twig\Components;

use App\Entity\Consultation;
use App\Repository\ConsultationRepository;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;
use Symfony\UX\LiveComponent\Attribute\LiveProp;
use Symfony\UX\LiveComponent\DefaultActionTrait;

#[AsLiveComponent()]
final class ChercheConsultation
{
    use DefaultActionTrait;

    #[LiveProp(writable: true)]
    public int $consultId = 0;

    public function __construct(private ConsultationRepository $consultationRepository)
    {
    }

    public function getConsultation(): ?Consultation
    {
        return $this->consultationRepository->find($this->consultId);
    }
}
