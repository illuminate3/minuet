<?php

declare(strict_types=1);

namespace App\Entity;

use App\Entity\Trait\CreatedAtTrait;
use App\Entity\Trait\EntityIdTrait;
use App\Entity\Trait\ModifiedAtTrait;
use App\Repository\AccountRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AccountRepository::class)]
class Account
{

    use EntityIdTrait;
    use CreatedAtTrait;
    use ModifiedAtTrait;

    #[ORM\Column(type: 'string', length: 100, unique: true)]
    private $name;

    #[ORM\Column(length: 10, unique: true)]
    private ?int $primaryUser = null;

    #[ORM\Column(length: 32, unique: true)]
    private ?string $stripeCustomerId = null;

    #[ORM\ManyToOne(inversedBy: 'account_id')]
    #[ORM\JoinColumn(nullable: true)]
    #[ORM\JoinColumn(nullable: true)]
    private ?Subscription $subscription = null;

    #[ORM\OneToMany(mappedBy: 'accountId', targetEntity: Product::class)]
    private Collection $products;

    #[ORM\OneToMany(mappedBy: 'account', targetEntity: Thread::class)]
    private Collection $threads;

    #[ORM\Column(type: Types::BOOLEAN, length: 1, options: ['default' => '0'])]
    private bool $isSubscriptionActive = false;

    #[ORM\Column(type: Types::BOOLEAN, length: 1, options: ['default' => '0'])]
    private ?bool $isExpiring = false;

    #[ORM\Column(type: Types::BOOLEAN, length: 1, options: ['default' => '0'])]
    private ?bool $isPastDue = false;

    public function __construct()
    {
        $this->products = new ArrayCollection();
        $this->threads = new ArrayCollection();
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
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param  string  $name
     *
     * @return $this
     */
    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Subscription|null
     */
    public function getSubscription(): ?Subscription
    {
        return $this->subscription;
    }

    /**
     * @param  Subscription|null  $subscription
     *
     * @return $this
     */
    public function setSubscription(?Subscription $subscription): self
    {
        $this->subscription = $subscription;

        return $this;
    }

    /**
     * @return Collection<int, Product>
     */
    public function getProducts(): Collection
    {
        return $this->products;
    }

    /**
     * @param  Product  $product
     *
     * @return $this
     */
    public function addProduct(Product $product): self
    {
        if (!$this->products->contains($product)) {
            $this->products->add($product);
            $product->setAccountId($this);
        }

        return $this;
    }

    /**
     * @param  Product  $product
     *
     * @return $this
     */
    public function removeProduct(Product $product): self
    {
        if ($this->products->removeElement($product)) {
            // set the owning side to null (unless already changed)
            if ($product->getAccountId() === $this) {
                $product->setAccountId(null);
            }
        }

        return $this;
    }

    /**
     * @return int|null
     */
    public function getPrimaryUser(): ?int
    {
        return $this->primaryUser;
    }

    /**
     * @param  int  $primaryUser
     *
     * @return $this
     */
    public function setPrimaryUser(int $primaryUser): self
    {
        $this->primaryUser = $primaryUser;

        return $this;
    }

    /**
     * @return Collection
     */
    public function getThreads(): Collection
    {
        return $this->threads;
    }

    /**
     * @param  Thread  $thread
     *
     * @return $this
     */
    public function addThread(Thread $thread): self
    {
        if (!$this->threads->contains($thread)) {
            $this->threads->add($thread);
            $thread->setAccount($this);
        }

        return $this;
    }

    /**
     * @param  Thread  $thread
     *
     * @return $this
     */
    public function removeThread(Thread $thread): self
    {
        if ($this->threads->removeElement($thread)) {
            // set the owning side to null (unless already changed)
            if ($thread->getAccount() === $this) {
                $thread->setAccount(null);
            }
        }

        return $this;
    }

    /**
     * @param  bool  $isActive
     *
     * @return $this
     */
    public function setIsSubscriptionActive(bool $isActive): self
    {
        $this->isSubscriptionActive = $isActive;

        return $this;
    }

    /**
     * @return bool|null
     */
    public function getIsSubscriptionActive(): ?bool
    {
        return $this->isSubscriptionActive ? true : false;
    }

    /**
     * @return bool|null
     */
    public function isIsExpiring(): ?bool
    {
        return $this->isExpiring;
    }

    /**
     * @param  bool  $isExpiring
     *
     * @return $this
     */
    public function setIsExpiring(bool $isExpiring): static
    {
        $this->isExpiring = $isExpiring;

        return $this;
    }

    /**
     * @return bool|null
     */
    public function isIsPastDue(): ?bool
    {
        return $this->isPastDue;
    }

    /**
     * @param  bool  $isPastDue
     *
     * @return $this
     */
    public function setIsPastDue(bool $isPastDue): static
    {
        $this->isPastDue = $isPastDue;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getStripeCustomerId(): ?string
    {
        return $this->stripeCustomerId;
    }

    /**
     * @param  string  $stripeCustomerId
     *
     * @return $this
     */
    public function setStripeCustomerId(string $stripeCustomerId): static
    {
        $this->stripeCustomerId = $stripeCustomerId;

        return $this;
    }

}
