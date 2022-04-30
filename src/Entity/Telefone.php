<?php

namespace App\Entity;

use App\Repository\TelefoneRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TelefoneRepository::class)]
class Telefone
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'integer')]
    private $ddd;

    #[ORM\Column(type: 'integer')]
    private $numero;

    #[ORM\ManyToOne(targetEntity: Cliente::class, inversedBy: 'telefones')]
    #[ORM\JoinColumn(nullable: false)]
    private $cliente;

    #[ORM\ManyToOne(targetEntity: Operadora::class, inversedBy: 'telefones')]
    private $operadora;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDdd(): ?int
    {
        return $this->ddd;
    }

    public function setDdd(int $ddd): self
    {
        $this->ddd = $ddd;

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

    public function getCliente(): ?Cliente
    {
        return $this->cliente;
    }

    public function setCliente(?Cliente $cliente): self
    {
        $this->cliente = $cliente;

        return $this;
    }

    public function getOperadora(): ?Operadora
    {
        return $this->operadora;
    }

    public function setOperadora(?Operadora $operadora): self
    {
        $this->operadora = $operadora;

        return $this;
    }
}
