<?php

namespace App\Entity;

use App\Repository\BurgerRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BurgerRepository::class)]
class Burger
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $nom_burger;

    #[ORM\Column(type: 'integer')]
    private $prix_burger;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomBurger(): ?string
    {
        return $this->nom_burger;
    }

    public function setNomBurger(string $nom_burger): self
    {
        $this->nom_burger = $nom_burger;

        return $this;
    }

    public function getPrixBurger(): ?int
    {
        return $this->prix_burger;
    }

    public function setPrixBurger(int $prix_burger): self
    {
        $this->prix_burger = $prix_burger;

        return $this;
    }
}
