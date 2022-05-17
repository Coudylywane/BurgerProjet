<?php

namespace App\Entity;

use App\Repository\BurgerRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints\Cascade;

#[ORM\Entity(repositoryClass: BurgerRepository::class)]
class Burger
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    public $nom_burger;

    #[ORM\Column(type: 'integer')]
    public $prix_burger;

    #[ORM\Column(type: 'string', length: 255)]
    private $description;

    #[ORM\OneToMany(mappedBy: 'burgers', targetEntity: Commande::class)]
    private $commandes;

    #[ORM\OneToMany(mappedBy: 'burgers', targetEntity: Menu::class)]
    private $menus;

    #[ORM\ManyToMany(targetEntity: Complement::class, mappedBy: 'burgers')]
    private $complements;

    #[ORM\OneToMany(mappedBy: 'burgers', targetEntity: Image::class ,cascade:["persist"])]
    public $images;

    public function __construct()
    {
        $this->commandes = new ArrayCollection();
        $this->menus = new ArrayCollection();
        $this->complements = new ArrayCollection();
        $this->images = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function __toString()
    {
        return $this ->nom_burger;
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
     * @return Collection<int, Commande>
     */
    public function getCommandes(): Collection
    {
        return $this->commandes;
    }

    public function addCommande(Commande $commande): self
    {
        if (!$this->commandes->contains($commande)) {
            $this->commandes[] = $commande;
            $commande->setBurgers($this);
        }

        return $this;
    }

    public function removeCommande(Commande $commande): self
    {
        if ($this->commandes->removeElement($commande)) {
            // set the owning side to null (unless already changed)
            if ($commande->getBurgers() === $this) {
                $commande->setBurgers(null);
            }
        }

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
            $menu->setBurgers($this);
        }

        return $this;
    }

    public function removeMenu(Menu $menu): self
    {
        if ($this->menus->removeElement($menu)) {
            // set the owning side to null (unless already changed)
            if ($menu->getBurgers() === $this) {
                $menu->setBurgers(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Complement>
     */
    public function getComplements(): Collection
    {
        return $this->complements;
    }

    public function addComplement(Complement $complement): self
    {
        if (!$this->complements->contains($complement)) {
            $this->complements[] = $complement;
            $complement->addBurger($this);
        }

        return $this;
    }

    public function removeComplement(Complement $complement): self
    {
        if ($this->complements->removeElement($complement)) {
            $complement->removeBurger($this);
        }

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
            $image->setBurgers($this);
        }

        return $this;
    }

    public function removeImage(Image $image): self
    {
        if ($this->images->removeElement($image)) {
            // set the owning side to null (unless already changed)
            if ($image->getBurgers() === $this) {
                $image->setBurgers(null);
            }
        }

        return $this;
    }
}
