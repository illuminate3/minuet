<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\AccountUserRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AccountUserRepository::class)]
class AccountUser
{
    #[ORM\Id]
    #[ORM\ManyToOne(targetEntity: Account::class, inversedBy: 'accountUser')]
    #[ORM\JoinColumn(nullable: false)]
    private $account;

    #[ORM\Id]
    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'accountUser')]
    #[ORM\JoinColumn(nullable: false)]
    private $user;

    public function getAccount(): ?Account
    {
        return $this->account;
    }

    public function setAccount(?Account $account): self
    {
        $this->account = $account;

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

}
