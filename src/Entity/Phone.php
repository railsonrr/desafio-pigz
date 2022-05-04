<?php

namespace App\Entity;

use App\Repository\PhoneRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: PhoneRepository::class)]
class Phone
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]

    #[Groups("group1")]
    private $id;

    #[ORM\Column(type: 'integer')]
    #[Groups("group1")]
    private $ddd;

    #[ORM\Column(type: 'integer')]
    #[Groups("group1")]
    private $numero;

    #[ORM\ManyToOne(targetEntity: Client::class, inversedBy: 'phones')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups("group1")]
    private $client;

    #[ORM\ManyToOne(targetEntity: Operator::class, inversedBy: 'phones')]
    #[Groups("group1")]
    private $operator;

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

    public function getClient(): ?Client
    {
        return $this->client;
    }

    public function setClient(?Client $client): self
    {
        $this->client = $client;

        return $this;
    }

    public function getOperator(): ?Operator
    {
        return $this->operator;
    }

    public function setOperator(?Operator $operator): self
    {
        $this->operator = $operator;

        return $this;
    }
}
