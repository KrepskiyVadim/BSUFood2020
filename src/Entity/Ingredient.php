<?php

namespace App\Entity;

use App\Repository\IngredientRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=IngredientRepository::class)
 */
class Ingredient
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity=DishComposition::class, mappedBy="ingredient")
     */
    private $ingredient_id;

    public function __construct()
    {
        $this->ingredient_id = new ArrayCollection();
    }

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

    /**
     * @return Collection|DishComposition[]
     */
    public function getIngredientId(): Collection
    {
        return $this->ingredient_id;
    }

    public function addIngredientId(DishComposition $ingredientId): self
    {
        if (!$this->ingredient_id->contains($ingredientId)) {
            $this->ingredient_id[] = $ingredientId;
            $ingredientId->setIngredient($this);
        }

        return $this;
    }

    public function removeIngredientId(DishComposition $ingredientId): self
    {
        if ($this->ingredient_id->removeElement($ingredientId)) {
            // set the owning side to null (unless already changed)
            if ($ingredientId->getIngredient() === $this) {
                $ingredientId->setIngredient(null);
            }
        }

        return $this;
    }
    public function __toString()
    {
        return (string) $this->getId();
    }
}
