<?php

namespace App\Entity;

use App\Repository\PaiementRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PaiementRepository::class)]
class Paiement
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'integer')]
    private $montant_paiement;



    #[ORM\OneToOne(mappedBy: 'paiements', targetEntity: Commande::class, cascade: ['persist', 'remove'])]
    private $commande;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMontantPaiement(): ?int
    {
        return $this->montant_paiement;
    }

    public function setMontantPaiement(int $montant_paiement): self
    {
        $this->montant_paiement = $montant_paiement;

        return $this;
    }


    public function getCommande(): ?Commande
    {
        return $this->commande;
    }

    public function setCommande(?Commande $commande): self
    {
        // unset the owning side of the relation if necessary
        if ($commande === null && $this->commande !== null) {
            $this->commande->setPaiements(null);
        }

        // set the owning side of the relation if necessary
        if ($commande !== null && $commande->getPaiements() !== $this) {
            $commande->setPaiements($this);
        }

        $this->commande = $commande;

        return $this;
    }
}
