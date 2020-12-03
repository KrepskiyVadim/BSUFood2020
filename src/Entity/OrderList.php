<?php

namespace App\Entity;

use App\Repository\OrderListRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=OrderListRepository::class)
 */
class OrderList
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=OrderFromMenu::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $order_id;

    /**
     * @ORM\Column(type="decimal", precision=5, scale=2)
     */
    private $sum;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getOrderId(): ?OrderFromMenu
    {
        return $this->order_id;
    }

    public function setOrderId(?OrderFromMenu $order_id): self
    {
        $this->order_id = $order_id;

        return $this;
    }

    public function getSum(): ?string
    {
        return $this->sum;
    }

    public function setSum(string $sum): self
    {
        $this->sum = $sum;

        return $this;
    }
}
