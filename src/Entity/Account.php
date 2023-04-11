<?php

declare(strict_types=1);

namespace App\Entity;

use App\Entity\Trait\CreatedAtTrait;
use App\Repository\AccountRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AccountRepository::class)]
class Account
{
    use CreatedAtTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 20, unique: true)]
    private $reference;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'account')]
    #[ORM\JoinColumn(nullable: false)]
    private $users;

    #[ORM\OneToMany(mappedBy: 'account', targetEntity: AccountListing::class, orphanRemoval: true)]
    private $accountListing;

    public function __construct()
    {
        $this->accountListing = new ArrayCollection();
        $this->created_at = new \DateTimeImmutable();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getReference(): ?string
    {
        return $this->reference;
    }

    public function setReference(string $reference): self
    {
        $this->reference = $reference;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->users;
    }

    public function setUser(?User $users): self
    {
        $this->users = $users;

        return $this;
    }

    /**
     * @return Collection|AccountListing[]
     */
    public function getAccountListing(): Collection
    {
        return $this->accountListing;
    }

    public function addAccountDetail(AccountListing $accountDetail): self
    {
        if (!$this->accountListing->contains($accountDetail)) {
            $this->accountListing[] = $accountDetail;
            $accountDetail->setAccount($this);
        }

        return $this;
    }

    public function removeAccountDetail(AccountListing $accountDetail): self
    {
        if ($this->accountListing->removeElement($accountDetail)) {
            // set the owning side to null (unless already changed)
            if ($accountDetail->getAccount() === $this) {
                $accountDetail->setAccount(null);
            }
        }

        return $this;
    }

}
