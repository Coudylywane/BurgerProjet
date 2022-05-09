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

    #[ORM\Column(type: 'datetime')]
    private $date_paiement;

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

    public function getDatePaiement(): ?\DateTimeInterface
    {
        return $this->date_paiement;
    }

    public function setDatePaiement(\DateTimeInterface $date_paiement): self
    {
        $this->date_paiement = $date_paiement;

        return $this;
    }
}
