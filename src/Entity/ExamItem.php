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
    #[Groups(["exam_item_read"])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(["exam_item_read", "exam_item_write"])]
    private ?string $nom = null;

    #[ORM\Column]
    #[Groups(["exam_item_read", "exam_item_write"])]
    private ?int $prix = null;

    #[ORM\ManyToMany(targetEntity: Exament::class, mappedBy: 'items')]
    private Collection $examents;

    public function __construct()
    {
        $this->examents = new ArrayCollection();
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
}
