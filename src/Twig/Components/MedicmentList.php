<?php

namespace App\Twig\Components;

use App\Repository\MedicamentRepository;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;
use Symfony\UX\LiveComponent\Attribute\LiveProp;
use Symfony\UX\LiveComponent\DefaultActionTrait;

#[AsLiveComponent()]
final class MedicmentList
{
    use DefaultActionTrait;

    public function __construct(private MedicamentRepository $medicamentRepository)
    {
    }

    #[LiveProp(writable: true)]
    public string $query = '';

    public function getMedicaments()
    {
        if ($this->query == '') {
            return $this->medicamentRepository->findBy([], limit: 20);
        }

        return $this->medicamentRepository->findByQuery($this->query);;
    }
}
