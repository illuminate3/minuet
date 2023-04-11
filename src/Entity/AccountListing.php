<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\AccountListingRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AccountListingRepository::class)]
class AccountListing
{
    #[ORM\Id]
    #[ORM\ManyToOne(targetEntity: Account::class, inversedBy: 'accountListing')]
    #[ORM\JoinColumn(nullable: false)]
    private $account;

    #[ORM\Id]
    #[ORM\ManyToOne(targetEntity: Product::class, inversedBy: 'accountListing')]
    #[ORM\JoinColumn(nullable: false)]
    private $product;

    public function getAccount(): ?Account
    {
        return $this->account;
    }

    public function setAccount(?Account $account): self
    {
        $this->account = $account;

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
