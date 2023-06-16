<?php

declare(strict_types=1);

namespace App\Entity;

use App\Entity\Trait\CreatedAtTrait;
use App\Repository\OrderRepository;
use DateTimeImmutable;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: OrderRepository::class)]
class Order
{
    use CreatedAtTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id;

    #[ORM\Column(type: 'string', length: 20, unique: true)]
    private ?string $reference;

//    #[ORM\ManyToOne(targetEntity: Coupons::class, inversedBy: 'order')]
//    private $coupons;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'order')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user;

    #[ORM\OneToMany(mappedBy: 'order', targetEntity: OrderDetail::class, orphanRemoval: true)]
    private ArrayCollection $orderDetail;

    public function __construct()
    {
        $this->orderDetail = new ArrayCollection();
        $this->created_at = new DateTimeImmutable();
    }

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return string|null
     */
    public function getReference(): ?string
    {
        return $this->reference;
    }

    /**
     * @param  string  $reference
     *
     * @return $this
     */
    public function setReference(string $reference): self
    {
        $this->reference = $reference;

        return $this;
    }

    /**
     * @return User|null
     */
    public function getUser(): ?User
    {
        return $this->user;
    }

    /**
     * @param  User|null  $user
     *
     * @return $this
     */
    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return Collection
     */
    public function getOrderDetail(): Collection
    {
        return $this->orderDetail;
    }

    /**
     * @param  OrderDetail  $orderDetail
     *
     * @return $this
     */
    public function addOrderDetail(OrderDetail $orderDetail): self
    {
        if (!$this->orderDetail->contains($orderDetail)) {
            $this->orderDetail[] = $orderDetail;
            $orderDetail->setOrder($this);
        }

        return $this;
    }

    /**
     * @param  OrderDetail  $orderDetail
     *
     * @return $this
     */
    public function removeOrderDetail(OrderDetail $orderDetail): self
    {
        if ($this->orderDetail->removeElement($orderDetail)) {
            // set the owning side to null (unless already changed)
            if ($orderDetail->getOrder() === $this) {
                $orderDetail->setOrder(null);
            }
        }

        return $this;
    }

}
