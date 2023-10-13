<?php

namespace App\Entity;

use App\Repository\ParametreViteauxRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ParametreViteauxRepository::class)]
class ParametreViteaux
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $temperature = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $poids = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $tails = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $tension_arterielle = null;

    #[ORM\OneToOne(inversedBy: 'parametreViteaux', cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?Consultation $consultation = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTemperature(): ?string
    {
        return $this->temperature;
    }

    public function setTemperature(?string $temperature): static
    {
        $this->temperature = $temperature;

        return $this;
    }

    public function getPoids(): ?string
    {
        return $this->poids;
    }

    public function setPoids(?string $poids): static
    {
        $this->poids = $poids;

        return $this;
    }

    public function getTails(): ?string
    {
        return $this->tails;
    }

    public function setTails(?string $tails): static
    {
        $this->tails = $tails;

        return $this;
    }

    public function getTensionArterielle(): ?string
    {
        return $this->tension_arterielle;
    }

    public function setTensionArterielle(?string $tension_arterielle): static
    {
        $this->tension_arterielle = $tension_arterielle;

        return $this;
    }

    public function getConsultation(): ?Consultation
    {
        return $this->consultation;
    }

    public function setConsultation(Consultation $consultation): static
    {
        $this->consultation = $consultation;

        return $this;
    }
}
