<?php

namespace App\Entity;
use Symfony\Component\Validator\Constraints as Assert;
use App\Repository\ImcRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ImcRepository::class)]
class Imc
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $sexe = null;

    #[ORM\Column(nullable: true)]
    #[Assert\Positive(message: 'Vous devez entrer une valeur  valide pour cette champ ')]
    private ?int $age = null;

    #[ORM\Column(nullable: true)]
    #[Assert\Positive(message: 'Vous devez entrer une valeur  valide pour cette champ ')]
    private ?float $taille = null;
    

    #[ORM\Column(nullable: true)]
    #[Assert\Positive(message: 'Vous devez entrer une valeur  valide pour cette champ ')]
    private ?float $poids = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $categorieIMC = null;

    #[ORM\Column(nullable: true)]
    private ?float $poidsIdeal = null;

    #[ORM\Column(nullable: true)]
    private ?float $IMC = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSexe(): ?string
    {
        return $this->sexe;
    }

    public function setSexe(?string $sexe): static
    {
        $this->sexe = $sexe;

        return $this;
    }
 
    public function getAge(): ?int
    {
        return $this->age;
    }

    public function setAge(?int $age): static
    {
        $this->age = $age;

        return $this;
    }

    public function getTaille(): ?float
    {
        return $this->taille;
    }

    public function setTaille(?float $taille): static
    {
        $this->taille = $taille;

        return $this;
    }

    public function getPoids(): ?float
    {
        return $this->poids;
    }

    public function setPoids(?float $poids): static
    {
        $this->poids = $poids;

        return $this;
    }

    public function getCategorieIMC(): ?string
    {
        return $this->categorieIMC;
    }

    public function setCategorieIMC(?string $categorieIMC): static
    {
        $this->categorieIMC = $categorieIMC;

        return $this;
    }

    public function getPoidsIdeal(): ?float
    {
        return $this->poidsIdeal;
    }

    public function setPoidsIdeal(?float $poidsIdeal): static
    {
        $this->poidsIdeal = $poidsIdeal;

        return $this;
    }

    public function getIMC(): ?float
    {
        return $this->IMC;
    }

    public function setIMC(?float $IMC): static
    {
        $this->IMC = $IMC;

        return $this;
    }
}
