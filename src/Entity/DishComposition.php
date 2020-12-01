<?php

namespace App\Entity;

use App\Repository\DishCompositionRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=DishCompositionRepository::class)
 */
class DishComposition
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Dish::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $ingredient;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIngredient(): ?Dish
    {
        return $this->ingredient;
    }

    public function setIngredient(?Dish $ingredient): self
    {
        $this->ingredient = $ingredient;

        return $this;
    }
}
