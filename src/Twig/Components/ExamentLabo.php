<?php

namespace App\Twig\Components;

use App\Entity\Exament;
use App\Repository\ExamentRepository;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;
use Symfony\UX\LiveComponent\Attribute\LiveProp;
use Symfony\UX\LiveComponent\DefaultActionTrait;

#[AsLiveComponent()]
final class ExamentLabo
{
    use DefaultActionTrait;

    #[LiveProp(writable: true)]
    public int $examId = 0;

    public function __construct(private ExamentRepository $examentRepository)
    {
    }

    public function getExament(): ?Exament
    {
        return $this->examentRepository->findOneBy(['id' => $this->examId, 'etat' => 0, 'is_payed' => 1]);
    }

    public function getExaments()
    {
        return $this->examentRepository->findBy(['etat' => 0, 'is_payed' => 1], limit: 5, orderBy: ['id' => 'DESC',]);
    }
}
