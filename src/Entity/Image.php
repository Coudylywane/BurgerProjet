<?php

namespace App\Entity;

use App\Repository\ImageRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ImageRepository::class)]
class Image
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
   public $nom_image;

    #[ORM\ManyToOne(targetEntity: Menu::class, inversedBy: 'images')]
    private $menus;

    #[ORM\ManyToOne(targetEntity: Burger::class, inversedBy: 'images')]
    private $burgers;

    #[ORM\ManyToOne(targetEntity: Complement::class, inversedBy: 'images')]
    private $complements;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomImage(): ?string
    {
        return $this->nom_image;
    }

    public function setNomImage(string $nom_image): self
    {
        $this->nom_image = $nom_image;

        return $this;
    }

    public function getMenus(): ?Menu
    {
        return $this->menus;
    }

    public function setMenus(?Menu $menus): self
    {
        $this->menus = $menus;

        return $this;
    }

    public function getBurgers(): ?Burger
    {
        return $this->burgers;
    }

    public function setBurgers(?Burger $burgers): self
    {
        $this->burgers = $burgers;

        return $this;
    }

    public function getComplements(): ?Complement
    {
        return $this->complements;
    }

    public function setComplements(?Complement $complements): self
    {
        $this->complements = $complements;

        return $this;
    }

    /* public function __toString()
    {
        return $this ->nom_image;
    } */
}
