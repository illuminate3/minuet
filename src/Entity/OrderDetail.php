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

    /**
     * @return int|null
     */
    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    /**
     * @param  int  $quantity
     *
     * @return $this
     */
    public function setQuantity(int $quantity): self
    {
        $this->quantity = $quantity;

        return $this;
    }

    /**
     * @return int|null
     */
    public function getPrice(): ?int
    {
        return $this->price;
    }

    /**
     * @param  int  $price
     *
     * @return $this
     */
    public function setPrice(int $price): self
    {
        $this->price = $price;

        return $this;
    }

    /**
     * @return Order|null
     */
    public function getOrder(): ?Order
    {
        return $this->order;
    }

    /**
     * @param  Order|null  $order
     *
     * @return $this
     */
    public function setOrder(?Order $order): self
    {
        $this->order = $order;

        return $this;
    }

    /**
     * @return Product|null
     */
    public function getProduct(): ?Product
    {
        return $this->product;
    }

    /**
     * @param  Product|null  $product
     *
     * @return $this
     */
    public function setProduct(?Product $product): self
    {
        $this->product = $product;

        return $this;
    }

}
