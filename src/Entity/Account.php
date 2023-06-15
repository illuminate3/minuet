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

    public function getSubscription(): ?Subscription
    {
        return $this->subscription;
    }

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

    public function addProduct(Product $product): self
    {
        if (!$this->products->contains($product)) {
            $this->products->add($product);
            $product->setAccountId($this);
        }

        return $this;
    }

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

    public function getPrimaryUser(): ?int
    {
        return $this->primaryUser;
    }

    public function setPrimaryUser(int $primaryUser): self
    {
        $this->primaryUser = $primaryUser;

        return $this;
    }

    /**
     * @return Collection<int, Thread>
     */
    public function getThreads(): Collection
    {
        return $this->threads;
    }

    public function addThread(Thread $thread): self
    {
        if (!$this->threads->contains($thread)) {
            $this->threads->add($thread);
            $thread->setAccount($this);
        }

        return $this;
    }

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

    public function setIsSubscriptionActive(bool $isActive): self
    {
        $this->isSubscriptionActive = $isActive;

        return $this;
    }

    public function getIsSubscriptionActive(): ?bool
    {
        return $this->isSubscriptionActive ? true : false;
    }

    public function isIsExpiring(): ?bool
    {
        return $this->isExpiring;
    }

    public function setIsExpiring(bool $isExpiring): static
    {
        $this->isExpiring = $isExpiring;

        return $this;
    }

    public function isIsPastDue(): ?bool
    {
        return $this->isPastDue;
    }

    public function setIsPastDue(bool $isPastDue): static
    {
        $this->isPastDue = $isPastDue;

        return $this;
    }

    public function getStripeCustomerId(): ?string
    {
        return $this->stripeCustomerId;
    }

    public function setStripeCustomerId(string $stripeCustomerId): static
    {
        $this->stripeCustomerId = $stripeCustomerId;

        return $this;
    }

}
