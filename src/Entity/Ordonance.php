<?php

namespace App\Entity;

use App\Repository\OrdonanceRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: OrdonanceRepository::class)]
#[ORM\HasLifecycleCallbacks]
class Ordonance
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $create_at = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $contenue = null;

    #[ORM\ManyToOne(inversedBy: 'ordonances')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Consultation $consulatation = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCreateAt(): ?\DateTimeImmutable
    {
        return $this->create_at;
    }

    public function setCreateAt(\DateTimeImmutable $create_at): static
    {
        $this->create_at = $create_at;

        return $this;
    }

    public function getContenue(): ?string
    {
        return $this->contenue;
    }

    public function setContenue(string $contenue): static
    {
        $this->contenue = $contenue;

        return $this;
    }

    public function getConsulatation(): ?Consultation
    {
        return $this->consulatation;
    }

    public function setConsulatation(?Consultation $consulatation): static
    {
        $this->consulatation = $consulatation;

        return $this;
    }

    #[ORM\PrePersist]
    public function prePersist()
    {
        $this->create_at = new \DateTimeImmutable();
    }

    public function  contentToArray(): array
    {
        return explode(";", $this->contenue);
    }
}
