<?php

namespace App\Entity;

use App\Repository\ConsultationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
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

    #[ORM\OneToMany(mappedBy: 'consulatation', targetEntity: Ordonance::class, orphanRemoval: true)]
    private Collection $ordonances;

    #[ORM\OneToMany(mappedBy: 'consultation', targetEntity: Exament::class, orphanRemoval: true)]
    private Collection $examents;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    #[Groups('READ:CONSULTATION')]
    private ?string $raison = null;

    #[ORM\Column(length: 255)]
    #[Groups('READ:CONSULTATION')]
    private ?string $prix = null;

    #[ORM\OneToOne(mappedBy: 'consultation', cascade: ['persist', 'remove'])]
    private ?ParametreViteaux $parametreViteaux = null;

    #[ORM\OneToMany(mappedBy: 'consultation', targetEntity: Remarque::class, orphanRemoval: true)]
    private Collection $remarques;

    public function __construct()
    {
        $this->ordonances = new ArrayCollection();
        $this->examents = new ArrayCollection();
        $this->remarques = new ArrayCollection();
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

    /**
     * @return Collection<int, Ordonance>
     */
    public function getOrdonances(): Collection
    {
        return $this->ordonances;
    }

    public function addOrdonance(Ordonance $ordonance): static
    {
        if (!$this->ordonances->contains($ordonance)) {
            $this->ordonances->add($ordonance);
            $ordonance->setConsulatation($this);
        }

        return $this;
    }

    public function removeOrdonance(Ordonance $ordonance): static
    {
        if ($this->ordonances->removeElement($ordonance)) {
            // set the owning side to null (unless already changed)
            if ($ordonance->getConsulatation() === $this) {
                $ordonance->setConsulatation(null);
            }
        }

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
            $exament->setConsultation($this);
        }

        return $this;
    }

    public function removeExament(Exament $exament): static
    {
        if ($this->examents->removeElement($exament)) {
            // set the owning side to null (unless already changed)
            if ($exament->getConsultation() === $this) {
                $exament->setConsultation(null);
            }
        }

        return $this;
    }

    public function getRaison(): ?string
    {
        return $this->raison;
    }

    public function setRaison(?string $raison): static
    {
        $this->raison = $raison;

        return $this;
    }

    public function getPrix(): ?string
    {
        return $this->prix;
    }

    public function setPrix(string $prix): static
    {
        $this->prix = $prix;

        return $this;
    }

    public function getParametreViteaux(): ?ParametreViteaux
    {
        return $this->parametreViteaux;
    }

    public function setParametreViteaux(ParametreViteaux $parametreViteaux): static
    {
        // set the owning side of the relation if necessary
        if ($parametreViteaux->getConsultation() !== $this) {
            $parametreViteaux->setConsultation($this);
        }

        $this->parametreViteaux = $parametreViteaux;

        return $this;
    }

    /**
     * @return Collection<int, Remarque>
     */
    public function getRemarques(): Collection
    {
        return $this->remarques;
    }

    public function addRemarque(Remarque $remarque): static
    {
        if (!$this->remarques->contains($remarque)) {
            $this->remarques->add($remarque);
            $remarque->setConsultation($this);
        }

        return $this;
    }

    public function removeRemarque(Remarque $remarque): static
    {
        if ($this->remarques->removeElement($remarque)) {
            // set the owning side to null (unless already changed)
            if ($remarque->getConsultation() === $this) {
                $remarque->setConsultation(null);
            }
        }

        return $this;
    }
}
