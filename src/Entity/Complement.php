<?php

namespace App\Entity;

use App\Repository\ComplementRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ComplementRepository::class)]
class Complement
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    public $nom_complement;

    #[ORM\Column(type: 'integer')]
    public $prix_complement;

    #[ORM\Column(type: 'string', length: 255)]
    private $description;

    #[ORM\ManyToMany(targetEntity: Menu::class, mappedBy: 'complements')]
    private $menus;

    #[ORM\ManyToMany(targetEntity: Burger::class, inversedBy: 'complements')]
    private $burgers;

    #[ORM\OneToMany(mappedBy: 'complements', targetEntity: Image::class , cascade:["persist"])]
    public $images;

    public function __construct()
    {
        $this->menus = new ArrayCollection();
        $this->burgers = new ArrayCollection();
        $this->images = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }
    public function __toString()
    {
        return $this ->nom_complement;
    }

    public function getNomComplement(): ?string
    {
        return $this->nom_complement;
    }

    public function setNomComplement(string $nom_complement): self
    {
        $this->nom_complement = $nom_complement;

        return $this;
    }

    public function getPrixComplement(): ?int
    {
        return $this->prix_complement;
    }

    public function setPrixComplement(int $prix_complement): self
    {
        $this->prix_complement = $prix_complement;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return Collection<int, Menu>
     */
    public function getMenus(): Collection
    {
        return $this->menus;
    }

    public function addMenu(Menu $menu): self
    {
        if (!$this->menus->contains($menu)) {
            $this->menus[] = $menu;
            $menu->addComplement($this);
        }

        return $this;
    }

    public function removeMenu(Menu $menu): self
    {
        if ($this->menus->removeElement($menu)) {
            $menu->removeComplement($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, Burger>
     */
    public function getBurgers(): Collection
    {
        return $this->burgers;
    }

    public function addBurger(Burger $burger): self
    {
        if (!$this->burgers->contains($burger)) {
            $this->burgers[] = $burger;
        }

        return $this;
    }

    public function removeBurger(Burger $burger): self
    {
        $this->burgers->removeElement($burger);

        return $this;
    }

    /**
     * @return Collection<int, Image>
     */
    public function getImages(): Collection
    {
        return $this->images;
    }

    public function addImage(Image $image): self
    {
        if (!$this->images->contains($image)) {
            $this->images[] = $image;
            $image->setComplements($this);
        }

        return $this;
    }

    public function removeImage(Image $image): self
    {
        if ($this->images->removeElement($image)) {
            // set the owning side to null (unless already changed)
            if ($image->getComplements() === $this) {
                $image->setComplements(null);
            }
        }

        return $this;
    }
}
