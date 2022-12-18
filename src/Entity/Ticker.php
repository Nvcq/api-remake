<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\TickerRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TickerRepository::class)]
#[ApiResource]
class Ticker
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    private ?string $symbol = null;

    #[ORM\Column]
    private ?int $ranked = null;

    #[ORM\Column]
    private ?int $circulating_supply = null;

    #[ORM\Column]
    private ?int $total_supply = null;

    #[ORM\Column(nullable: true)]
    private ?int $price = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getSymbol(): ?string
    {
        return $this->symbol;
    }

    public function setSymbol(string $symbol): self
    {
        $this->symbol = $symbol;

        return $this;
    }

    public function getRanked(): ?int
    {
        return $this->ranked;
    }

    public function setRanked(int $ranked): self
    {
        $this->ranked = $ranked;

        return $this;
    }

    public function getCirculatingSupply(): ?int
    {
        return $this->circulating_supply;
    }

    public function setCirculatingSupply(int $circulating_supply): self
    {
        $this->circulating_supply = $circulating_supply;

        return $this;
    }

    public function getTotalSupply(): ?int
    {
        return $this->total_supply;
    }

    public function setTotalSupply(int $total_supply): self
    {
        $this->total_supply = $total_supply;

        return $this;
    }

    public function getPrice(): ?int
    {
        return $this->price;
    }

    public function setPrice(?int $price): self
    {
        $this->price = $price;

        return $this;
    }
}
