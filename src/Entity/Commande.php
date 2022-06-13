<?php

namespace App\Entity;

use App\Repository\CommandeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CommandeRepository::class)]
class Commande
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    




    #[ORM\OneToOne(inversedBy: 'commande', targetEntity: Paiement::class, cascade: ['persist', 'remove'])]
    private $paiements;

    #[ORM\ManyToMany(targetEntity: Menu::class, inversedBy: 'commandes')]
    private $menus;

    #[ORM\Column(type: 'string', length: 255)]
    private $etat;

    #[ORM\Column(type: 'string', length: 255)]
    private $date;

    #[ORM\Column(type: 'integer')]
    private $numero;

    #[ORM\ManyToMany(targetEntity: Burger::class, inversedBy: 'commandes')]
    private $burgers;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'commandes')]
    private $users;

    #[ORM\Column(type: 'integer')]
    private $montant;

    public function __construct()
    {
        $this->menus = new ArrayCollection();
        $this->burgers = new ArrayCollection();
        $this->etat = 'en cours';
    }

    
    public function getId(): ?int
    {
        return $this->id;
    }

    

    

   

    public function getPaiements(): ?Paiement
    {
        return $this->paiements;
    }

    public function setPaiements(?Paiement $paiements): self
    {
        $this->paiements = $paiements;

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
        }

        return $this;
    }

    public function removeMenu(Menu $menu): self
    {
        $this->menus->removeElement($menu);

        return $this;
    }

    public function getEtat(): ?string
    {
        return $this->etat;
    }

    public function setEtat(string $etat): self
    {
        $this->etat = $etat;

        return $this;
    }

   

    public function getNumero(): ?int
    {
        return $this->numero;
    }

    public function setNumero(int $numero): self
    {
        $this->numero = $numero;

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
     * Get the value of date
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set the value of date
     */
    public function setDate($date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getUsers(): ?User
    {
        return $this->users;
    }

    public function setUsers(?User $users): self
    {
        $this->users = $users;

        return $this;
    }

    public function getMontant(): ?int
    {
        return $this->montant;
    }

    public function setMontant(int $montant): self
    {
        $this->montant = $montant;

        return $this;
    }
}
