<?php

namespace App\Entity;

use App\Repository\MenuRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MenuRepository::class)]
class Menu
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    public $nom_menu;

    #[ORM\Column(type: 'integer')]
    public   $prix_menu;

    #[ORM\Column(type: 'string', length: 255)]
    private $description;

    #[ORM\OneToMany(mappedBy: 'menus', targetEntity: Commande::class)]
    private $commandes;

    #[ORM\ManyToOne(targetEntity: Burger::class, inversedBy: 'menus')]
    private $burgers;

    #[ORM\ManyToMany(targetEntity: Complement::class, inversedBy: 'menus')]
    private $complements;

    #[ORM\OneToMany(mappedBy: 'menus', targetEntity: Image::class ,cascade:["persist"])]
    public $images;

    public function __construct()
    {
        $this->commandes = new ArrayCollection();
        $this->complements = new ArrayCollection();
        $this->images = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomMenu(): ?string
    {
        return $this->nom_menu;
    }

    public function setNomMenu(string $nom_menu): self
    {
        $this->nom_menu = $nom_menu;

        return $this;
    }

    public function getPrixMenu(): ?int
    {
        return $this->prix_menu;
    }

    public function setPrixMenu(int $prix_menu): self
    {
        $this->prix_menu = $prix_menu;

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
            $commande->setMenus($this);
        }

        return $this;
    }

    public function removeCommande(Commande $commande): self
    {
        if ($this->commandes->removeElement($commande)) {
            // set the owning side to null (unless already changed)
            if ($commande->getMenus() === $this) {
                $commande->setMenus(null);
            }
        }

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
        }

        return $this;
    }

    public function removeComplement(Complement $complement): self
    {
        $this->complements->removeElement($complement);

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
            $image->setMenus($this);
        }

        return $this;
    }

    public function removeImage(Image $image): self
    {
        if ($this->images->removeElement($image)) {
            // set the owning side to null (unless already changed)
            if ($image->getMenus() === $this) {
                $image->setMenus(null);
            }
        }

        return $this;
    }
}
