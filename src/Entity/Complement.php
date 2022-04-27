<?php

namespace App\Entity;

use App\Repository\ComplementRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ComplementRepository::class)]
class Complement
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $nom_complement;

    #[ORM\Column(type: 'integer')]
    private $prix_complement;

    public function getId(): ?int
    {
        return $this->id;
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
}
