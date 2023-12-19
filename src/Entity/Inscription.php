<?php

namespace App\Entity;

use App\Repository\InscriptionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: InscriptionRepository::class)]
class Inscription
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $dateInscription = null;

    #[ORM\OneToOne(inversedBy: 'inscription', cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?Lyceen $lyceen = null;

    #[ORM\OneToMany(mappedBy: 'inscription', targetEntity: Atelier::class)]
    private Collection $ateliers;

    public function __construct()
    {
        $this->ateliers = new ArrayCollection();
        $this->dateInscription = new \DateTime();
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateInscription(): ?\DateTimeInterface
    {
        return $this->dateInscription;
    }

    public function setDateInscription(\DateTimeInterface $dateInscription): static
    {
        $this->dateInscription = $dateInscription;

        return $this;
    }

    public function getLyceen(): ?Lyceen
    {
        return $this->lyceen;
    }

    public function setLyceen(Lyceen $lyceen): static
    {
        $this->lyceen = $lyceen;

        return $this;
    }

    /**
     * @return Collection<int, Atelier>
     */
    public function getAteliers(): Collection
    {
        return $this->ateliers;
    }

    public function addAtelier(Atelier $atelier): static
    {
        if (!$this->ateliers->contains($atelier) && $this->ateliers->count() < 3) {
            $this->ateliers->add($atelier);
            $atelier->setInscription($this);
        }

        return $this;
    }

    public function removeAtelier(Atelier $atelier): static
    {
        if ($this->ateliers->removeElement($atelier)) {
            // set the owning side to null (unless already changed)
            if ($atelier->getInscription() === $this) {
                $atelier->setInscription(null);
            }
        }

        return $this;
    }

}
