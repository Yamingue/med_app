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

    public function getExament() : ?Exament
    {
        return $this->examentRepository->find($this->examId);
    }

    public function getExaments() 
    {
        return $this->examentRepository->findBy(['etat'=>0],limit:5,orderBy:['id'=>'DESC',]);
    }
}
