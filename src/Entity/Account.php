<?php

declare(strict_types=1);

namespace App\Entity;

use App\Entity\Trait\CreatedAtTrait;
use App\Entity\Traits\EntityIdTrait;
use App\Repository\AccountRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AccountRepository::class)]
class Account
{
//    use CreatedAtTrait;
    use EntityIdTrait;

    #[ORM\Column(type: 'string', length: 100, unique: true)]
    private $name;

    #[ORM\Column(length: 10, unique: true)]
    private ?int $primaryUser = null;


//    #[ORM\Column(type: 'integer', length: 11)]
//    private $primary_user_id;


//    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'account')]
//    #[ORM\JoinColumn(nullable: false)]
//    private $user;

    #[ORM\ManyToOne(inversedBy: 'account_id')]
    #[ORM\JoinColumn(nullable: true)]
    #[ORM\JoinColumn(nullable: true)]
    private ?Subscription $subscription = null;

    #[ORM\OneToMany(mappedBy: 'accountId', targetEntity: Product::class)]
    private Collection $products;

    public function __construct()
    {
        $this->products = new ArrayCollection();
    }

//    public function __construct()
//    {
//        $this->created_at = new \DateTimeImmutable();
//    }

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

//    public function setUser(?User $user): self
//    {
//        $this->user = $user;
//
//        return $this;
//    }
//
//    public function getUser(): ?User
//    {
//        return $this->user;
//    }

//    /**
//     * @return Collection|AccountUser[]
//     */
//    public function getAccountUser(): Collection
//    {
//        return $this->accountUser;
//    }
//
//    public function addAccountUser(AccountUser $accountUser): self
//    {
//        if (!$this->accountUser->contains($accountUser)) {
//            $this->accountUser[] = $accountUser;
//            $accountUser->setAccount($this);
//        }
//
//        return $this;
//    }
//
//    public function removeAccountUser(AccountUser $accountUser): self
//    {
//        if ($this->accountUser->removeElement($accountUser)) {
//            // set the owning side to null (unless already changed)
//            if ($accountUser->getAccount() === $this) {
//                $accountUser->setAccount(null);
//            }
//        }
//
//        return $this;
//    }

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

}
