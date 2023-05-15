<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\OrderDetailRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: OrderDetailRepository::class)]
class OrderDetail
{
    #[ORM\Column(type: 'integer')]
    private ?int $quantity;

    #[ORM\Column(type: 'integer')]
    private ?int $price;

    #[ORM\Id]
    #[ORM\ManyToOne(targetEntity: Order::class, inversedBy: 'orderDetail')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Order $order;

    #[ORM\Id]
    #[ORM\ManyToOne(targetEntity: Product::class, inversedBy: 'orderDetail')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Product $product;

    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): self
    {
        $this->quantity = $quantity;

        return $this;
    }

    public function getPrice(): ?int
    {
        return $this->price;
    }

    public function setPrice(int $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getOrder(): ?Order
    {
        return $this->order;
    }

    public function setOrder(?Order $order): self
    {
        $this->order = $order;

        return $this;
    }

    public function getProduct(): ?Product
    {
        return $this->product;
    }

    public function setProduct(?Product $product): self
    {
        $this->product = $product;

        return $this;
    }
}
