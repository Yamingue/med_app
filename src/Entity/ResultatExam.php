<?php

namespace App\Entity;

use App\Repository\ResultatExamRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ResultatExamRepository::class)]
#[ORM\HasLifecycleCallbacks]
class ResultatExam
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $create_at = null;

    #[ORM\ManyToOne(inversedBy: 'resultatExams')]
    #[ORM\JoinColumn(nullable: false)]
    private ?ExamItem $item = null;

    #[ORM\Column(length: 255)]
    private ?string $valeur = null;

    #[ORM\ManyToOne(inversedBy: 'resultatExams')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Exament $examen = null;

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

    public function getItem(): ?ExamItem
    {
        return $this->item;
    }

    public function setItem(?ExamItem $item): static
    {
        $this->item = $item;

        return $this;
    }

    public function getValeur(): ?string
    {
        return $this->valeur;
    }

    public function setValeur(string $valeur): static
    {
        $this->valeur = $valeur;

        return $this;
    }

    public function getExamen(): ?Exament
    {
        return $this->examen;
    }

    public function setExamen(?Exament $examen): static
    {
        $this->examen = $examen;

        return $this;
    }
    #[ORM\PrePersist]
    public function prePersist()
    {
        $this->create_at = new \DateTimeImmutable();
    }
}
