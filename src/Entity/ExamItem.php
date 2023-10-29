<?php

namespace App\Entity;

use App\Repository\ExamItemRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: ExamItemRepository::class)]
class ExamItem
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(["exam_item_read", "read_id"])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(["exam_item_read", "exam_item_write"])]
    private ?string $nom = null;

    #[ORM\Column]
    #[Groups(["exam_item_read", "exam_item_write"])]
    private ?int $prix = null;

    #[ORM\ManyToMany(targetEntity: Exament::class, mappedBy: 'items')]
    private Collection $examents;

    #[ORM\OneToMany(mappedBy: 'item', targetEntity: ResultatExam::class, orphanRemoval: true)]
    private Collection $resultatExams;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(["exam_item_read", "exam_item_write"])]
    private ?string $normal_value = null;

    public function __construct()
    {
        $this->examents = new ArrayCollection();
        $this->resultatExams = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): static
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPrix(): ?int
    {
        return $this->prix;
    }

    public function setPrix(int $prix): static
    {
        $this->prix = $prix;

        return $this;
    }

    /**
     * @return Collection<int, Exament>
     */
    public function getExaments(): Collection
    {
        return $this->examents;
    }

    public function addExament(Exament $exament): static
    {
        if (!$this->examents->contains($exament)) {
            $this->examents->add($exament);
            $exament->addItem($this);
        }

        return $this;
    }

    public function removeExament(Exament $exament): static
    {
        if ($this->examents->removeElement($exament)) {
            $exament->removeItem($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, ResultatExam>
     */
    public function getResultatExams(): Collection
    {
        return $this->resultatExams;
    }

    public function addResultatExam(ResultatExam $resultatExam): static
    {
        if (!$this->resultatExams->contains($resultatExam)) {
            $this->resultatExams->add($resultatExam);
            $resultatExam->setItem($this);
        }

        return $this;
    }

    public function removeResultatExam(ResultatExam $resultatExam): static
    {
        if ($this->resultatExams->removeElement($resultatExam)) {
            // set the owning side to null (unless already changed)
            if ($resultatExam->getItem() === $this) {
                $resultatExam->setItem(null);
            }
        }

        return $this;
    }

    public function getNormalValue(): ?string
    {
        return $this->normal_value;
    }

    public function setNormalValue(?string $normal_value): static
    {
        $this->normal_value = $normal_value;

        return $this;
    }
}
