<?php

namespace App\Entity;

use App\Repository\ConsultationRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: ConsultationRepository::class)]
#[ORM\HasLifecycleCallbacks]
class Consultation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups('READ:CONSULTATION')]
    private ?int $id = null;

    #[ORM\Column]
    #[Groups('READ:CONSULTATION')]
    private ?\DateTimeImmutable $create_at = null;

    #[ORM\ManyToOne(inversedBy: 'consultations')]
    #[ORM\JoinColumn(nullable: false)]
    private ?TypeConsultation $type = null;

    #[ORM\Column]
    #[Groups('READ:CONSULTATION')]
    private ?bool $terminer = null;

    #[ORM\ManyToOne(inversedBy: 'consultations')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Patient $patient = null;

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

    public function getType(): ?TypeConsultation
    {
        return $this->type;
    }

    public function setType(?TypeConsultation $type): static
    {
        $this->type = $type;

        return $this;
    }

    public function isTerminer(): ?bool
    {
        return $this->terminer;
    }

    public function setTerminer(bool $terminer): static
    {
        $this->terminer = $terminer;

        return $this;
    }

    #[ORM\PrePersist]
    public function prePersist(){
        $this->create_at = new \DateTimeImmutable();
        $this->terminer = false;
    }

    public function getPatient(): ?Patient
    {
        return $this->patient;
    }

    public function setPatient(?Patient $patient): static
    {
        $this->patient = $patient;

        return $this;
    }
}
