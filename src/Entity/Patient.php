<?php

namespace App\Entity;

use App\Repository\PatientRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: PatientRepository::class)]
#[ORM\HasLifecycleCallbacks]
class Patient
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups('READ:PAIENT')]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups('READ:PAIENT')]
    private ?string $nom = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups('READ:PAIENT')]
    private ?string $prenom = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups('READ:PAIENT')]
    private ?string $telephone = null;

    #[ORM\Column]
    #[Groups('READ:PAIENT')]
    private ?\DateTimeImmutable $create_at = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    #[Groups('READ:PAIENT')]
    private ?\DateTimeInterface $ne_le = null;

    #[ORM\OneToMany(mappedBy: 'patient', targetEntity: Consultation::class, orphanRemoval: true)]
    private Collection $consultations;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $quartier = null;

    public function __construct()
    {
        $this->consultations = new ArrayCollection();
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

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(?string $prenom): static
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getTelephone(): ?string
    {
        return $this->telephone;
    }

    public function setTelephone(?string $telephone): static
    {
        $this->telephone = $telephone;

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

    public function getNeLe(): ?\DateTimeInterface
    {
        return $this->ne_le;
    }

    public function setNeLe(?\DateTimeInterface $ne_le): static
    {
        $this->ne_le = $ne_le;

        return $this;
    }

    #[ORM\PrePersist]
    public function prePersiste()
    {
        $this->create_at = new \DateTimeImmutable();
    }

    /**
     * @return Collection<int, Consultation>
     */
    public function getConsultations(): Collection
    {
        return $this->consultations;
    }

    public function addConsultation(Consultation $consultation): static
    {
        if (!$this->consultations->contains($consultation)) {
            $this->consultations->add($consultation);
            $consultation->setPatient($this);
        }

        return $this;
    }

    public function removeConsultation(Consultation $consultation): static
    {
        if ($this->consultations->removeElement($consultation)) {
            // set the owning side to null (unless already changed)
            if ($consultation->getPatient() === $this) {
                $consultation->setPatient(null);
            }
        }

        return $this;
    }

    public function getQuartier(): ?string
    {
        return $this->quartier;
    }

    public function setQuartier(?string $quartier): static
    {
        $this->quartier = $quartier;

        return $this;
    }
}
