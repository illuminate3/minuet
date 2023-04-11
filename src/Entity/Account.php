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

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'account')]
    #[ORM\JoinColumn(nullable: false)]
    private $user;

    #[ORM\OneToMany(mappedBy: 'account', targetEntity: AccountListing::class, orphanRemoval: true)]
    private $accountListing;

    #[ORM\OneToMany(mappedBy: 'account', targetEntity: AccountUser::class, orphanRemoval: true)]
    private $accountUser;

    public function __construct()
    {
        $this->accountListing = new ArrayCollection();
        $this->accountUser = new ArrayCollection();
        $this->created_at = new \DateTimeImmutable();
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

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return Collection|AccountListing[]
     */
    public function getAccountListing(): Collection
    {
        return $this->accountListing;
    }

    public function addAccountListing(AccountListing $accountListing): self
    {
        if (!$this->accountListing->contains($accountListing)) {
            $this->accountListing[] = $accountListing;
            $accountListing->setAccount($this);
        }

        return $this;
    }

    public function removeAccountListing(AccountListing $accountListing): self
    {
        if ($this->accountListing->removeElement($accountListing)) {
            // set the owning side to null (unless already changed)
            if ($accountListing->getAccount() === $this) {
                $accountListing->setAccount(null);
            }
        }

        return $this;
    }


    /**
     * @return Collection|AccountUser[]
     */
    public function getAccountUser(): Collection
    {
        return $this->accountUser;
    }

    public function addAccountUser(AccountUser $accountUser): self
    {
        if (!$this->accountUser->contains($accountUser)) {
            $this->accountUser[] = $accountUser;
            $accountUser->setAccount($this);
        }

        return $this;
    }

    public function removeAccountUser(AccountUser $accountUser): self
    {
        if ($this->accountUser->removeElement($accountUser)) {
            // set the owning side to null (unless already changed)
            if ($accountUser->getAccount() === $this) {
                $accountUser->setAccount(null);
            }
        }

        return $this;
    }

}
