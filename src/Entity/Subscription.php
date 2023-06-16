<?php

declare(strict_types=1);

namespace App\Entity;

use App\Entity\Trait\EntityIdTrait;
use App\Entity\Trait\SlugTrait;
use App\Repository\SubscriptionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

#[ORM\Table(name: 'subscription')]
#[ORM\Entity(repositoryClass: SubscriptionRepository::class)]
#[UniqueEntity('plan')]
class Subscription
{
    use EntityIdTrait;
    use SlugTrait;

    #[ORM\Column(type: Types::STRING, length: 255)]
    private string $plan;

    #[ORM\Column]
    private ?float $price = null;

    #[ORM\Column(length: 45, nullable: true)]
    private ?string $frequency = null;

    #[ORM\Column(type: Types::STRING, length: 20)]
    private string $valid_until;

    #[ORM\Column(type: Types::STRING, length: 20, nullable: true)]
    private ?string $availability = null;

    #[ORM\Column(type: Types::STRING, length: 255, nullable: true)]
    private ?string $support = null;

    #[ORM\Column(type: Types::STRING, length: 45, nullable: true)]
    private ?string $stripe_price_id = null;

    #[ORM\OneToMany(mappedBy: 'subscription', targetEntity: Account::class)]
    private Collection $account_id;

    public function __construct()
    {
        $this->account_id = new ArrayCollection();
    }

    /**
     * @return string|null
     */
    public function getPlan(): ?string
    {
        return $this->plan;
    }

    /**
     * @param  string  $plan
     *
     * @return $this
     */
    public function setPlan(string $plan): self
    {
        $this->plan = $plan;

        return $this;
    }

//    public function getUser(): ?User
//    {
//        return $this->user;
//    }
//
//    public function setUser(?User $user): self
//    {
//        // unset the owning side of the relation if necessary
//        if (null === $user && null !== $this->user) {
//            $this->user->setSubscription(null);
//        }
//
//        // set the owning side of the relation if necessary
//        if (null !== $user && $user->getSubscription() !== $this) {
//            $user->setSubscription($this);
//        }
//
//        $this->user = $user;
//
//        return $this;
//    }


    /**
     * @return string|null
     */
    public function getValidUntil(): ?string
    {
        return $this->valid_until;
    }

    /**
     * @param  string  $valid_until
     *
     * @return $this
     */
    public function setValidUntil(string $valid_until): self
    {
        $this->valid_until = $valid_until;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getAvailability(): ?string
    {
        return $this->availability;
    }

    /**
     * @param  string|null  $availability
     *
     * @return $this
     */
    public function setAvailability(?string $availability): self
    {
        $this->availability = $availability;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getSupport(): ?string
    {
        return $this->support;
    }

    /**
     * @param  string|null  $support
     *
     * @return $this
     */
    public function setSupport(?string $support): self
    {
        $this->support = $support;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getStripePriceId(): ?string
    {
        return $this->stripe_price_id;
    }

    /**
     * @param  string|null  $stripe_price_id
     *
     * @return $this
     */
    public function setStripePriceId(?string $stripe_price_id): self
    {
        $this->stripe_price_id = $stripe_price_id;

        return $this;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->plan;
    }

    /**
     * @return float|null
     */
    public function getPrice(): ?float
    {
        return $this->price;
    }

    /**
     * @param  float  $price
     *
     * @return $this
     */
    public function setPrice(float $price): self
    {
        $this->price = $price;

        return $this;
    }

    /**
     * @return Collection
     */
    public function getAccountId(): Collection
    {
        return $this->account_id;
    }

    /**
     * @param  Account  $accountId
     *
     * @return $this
     */
    public function addAccountId(Account $accountId): self
    {
        if (!$this->account_id->contains($accountId)) {
            $this->account_id->add($accountId);
            $accountId->setSubscription($this);
        }

        return $this;
    }

    /**
     * @param  Account  $accountId
     *
     * @return $this
     */
    public function removeAccountId(Account $accountId): self
    {
        if ($this->account_id->removeElement($accountId)) {
            // set the owning side to null (unless already changed)
            if ($accountId->getSubscription() === $this) {
                $accountId->setSubscription(null);
            }
        }

        return $this;
    }

    /**
     * @return string|null
     */
    public function getFrequency(): ?string
    {
        return $this->frequency;
    }

    /**
     * @param  string  $frequency
     *
     * @return $this
     */
    public function setFrequency(string $frequency): static
    {
        $this->frequency = $frequency;

        return $this;
    }

}
