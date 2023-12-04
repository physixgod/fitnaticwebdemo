<?php

namespace App\Entity;

use App\Repository\CaloriqueRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CaloriqueRepository::class)]
class Calorique
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $objectif = null;

    #[ORM\Column(nullable: true)]
    private ?float $besoinsCaloriques = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $activite = null;

    #[ORM\Column(length: 255)]
    private ?string $regimeAlimentaire = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $niveauStress = null;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    private ?Imc $imcs = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getObjectif(): ?string
    {
        return $this->objectif;
    }

    public function setObjectif(?string $objectif): static
    {
        $this->objectif = $objectif;

        return $this;
    }

    public function getBesoinsCaloriques(): ?float
    {
        return $this->besoinsCaloriques;
    }

    public function setBesoinsCaloriques(?float $besoinsCaloriques): static
    {
        $this->besoinsCaloriques = $besoinsCaloriques;

        return $this;
    }

    public function getActivite(): ?string
    {
        return $this->activite;
    }

    public function setActivite(?string $activite): static
    {
        $this->activite = $activite;

        return $this;
    }

    public function getRegimeAlimentaire(): ?string
    {
        return $this->regimeAlimentaire;
    }

    public function setRegimeAlimentaire(string $regimeAlimentaire): static
    {
        $this->regimeAlimentaire = $regimeAlimentaire;

        return $this;
    }

    public function getNiveauStress(): ?string
    {
        return $this->niveauStress;
    }

    public function setNiveauStress(?string $niveauStress): static
    {
        $this->niveauStress = $niveauStress;

        return $this;
    }

    public function getImcs(): ?Imc
    {
        return $this->imcs;
    }

    public function setImcs(?Imc $imcs): static
    {
        $this->imcs = $imcs;

        return $this;
    }
}
