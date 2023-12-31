<?php

namespace App\Entity;

use App\Repository\ExamentRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ExamentRepository::class)]
#[ORM\HasLifecycleCallbacks]
class Exament
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'examents')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Consultation $consultation = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $create_at = null;

    #[ORM\Column]
    private ?bool $etat = null;

    #[ORM\ManyToMany(targetEntity: ExamItem::class, inversedBy: 'examents')]
    private Collection $items;

    #[ORM\Column(nullable: true)]
    private ?bool $is_payed = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $paye_at = null;

    #[ORM\Column(nullable: true)]
    private ?int $discount = null;

    #[ORM\OneToMany(mappedBy: 'examen', targetEntity: ResultatExam::class, orphanRemoval: true)]
    private Collection $resultatExams;

    public function __construct()
    {
        $this->items = new ArrayCollection();
        $this->resultatExams = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getConsultation(): ?Consultation
    {
        return $this->consultation;
    }

    public function setConsultation(?Consultation $consultation): static
    {
        $this->consultation = $consultation;

        return $this;
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

    #[ORM\PrePersist]
    public function prePersist()
    {
        $this->create_at = new \DateTimeImmutable();
        $this->etat = false;
        $this->is_payed = false;
    }

    public function isEtat(): ?bool
    {
        return $this->etat;
    }

    public function setEtat(bool $etat): static
    {
        $this->etat = $etat;

        return $this;
    }

    /**
     * @return Collection<int, ExamItem>
     */
    public function getItems(): Collection
    {
        return $this->items;
    }

    public function addItem(ExamItem $item): static
    {
        if (!$this->items->contains($item)) {
            $this->items->add($item);
        }

        return $this;
    }

    public function removeItem(ExamItem $item): static
    {
        $this->items->removeElement($item);

        return $this;
    }

    public function isIsPayed(): ?bool
    {
        return $this->is_payed;
    }

    public function setIsPayed(?bool $is_payed): static
    {
        $this->is_payed = $is_payed;

        return $this;
    }

    public function itemsToArray(): array
    {
        $items = [];
        foreach ($this->items as $it) {
            $item = [
                'nom' => $it->getNom(),
                'prix' => $it->getPrix(),
                'id' => $it->getId(),
            ];
            $items[] = $item;
        }

        return $items;
    }

    public function getAmount(): int
    {
        $total = 0;
        foreach ($this->items as $item) {
            $total += $item->getPrix();
        }
        return $total - $this->discount;
    }

    public function getPayeAt(): ?\DateTimeImmutable
    {
        return $this->paye_at;
    }

    public function setPayeAt(?\DateTimeImmutable $paye_at): static
    {
        $this->paye_at = $paye_at;

        return $this;
    }

    public function getDiscount(): ?int
    {
        return $this->discount;
    }

    public function setDiscount(?int $discount): static
    {
        $this->discount = $discount;

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
            $resultatExam->setExamen($this);
        }

        return $this;
    }

    public function removeResultatExam(ResultatExam $resultatExam): static
    {
        if ($this->resultatExams->removeElement($resultatExam)) {
            // set the owning side to null (unless already changed)
            if ($resultatExam->getExamen() === $this) {
                $resultatExam->setExamen(null);
            }
        }

        return $this;
    }
}
