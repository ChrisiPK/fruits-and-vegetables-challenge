<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

abstract class Produce
{
    #[ORM\Id]
    #[ORM\Column]
    protected ?int $id = null;

    #[ORM\Column(length: 255)]
    protected ?string $name = null;

    #[ORM\Column]
    protected ?int $quantity = null;

    public function setId($id): static
    {
        $this->id = $id;

        return $this;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Gets the name of this produce
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * Sets the name of this produce
     */
    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Gets the quantity in grams
     */
    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    /**
     * Sets the quantity in grams
     */
    public function setQuantity(int $quantity): static
    {
        $this->quantity = $quantity;

        return $this;
    }
}