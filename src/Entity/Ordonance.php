<?php

namespace App\Entity;

use App\Repository\OrdonanceRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
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

    #[ORM\ManyToOne(inversedBy: 'ordonances')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Consultation $consulatation = null;

    #[ORM\ManyToMany(targetEntity: Medicament::class, inversedBy: 'ordonances')]
    private Collection $items;

    public function __construct()
    {
        $this->items = new ArrayCollection();
    }

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

    public function  itemsToArray(): array
    {
        $items = [];
        foreach ($this->getItems() as $it) {
            $item = [
                'id' => $it->getId(),
                'nom' => $it->getNom(),
                'type' => $it->getType(),
            ];
            $items[] = $item;
        }
        return $items;
    }

    /**
     * @return Collection<int, Medicament>
     */
    public function getItems(): Collection
    {
        return $this->items;
    }

    public function addItem(Medicament $item): static
    {
        if (!$this->items->contains($item)) {
            $this->items->add($item);
        }

        return $this;
    }

    public function removeItem(Medicament $item): static
    {
        $this->items->removeElement($item);

        return $this;
    }
}
