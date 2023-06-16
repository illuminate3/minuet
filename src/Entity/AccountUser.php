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
    private ?Account $account;

    #[ORM\Id]
    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'accountUser')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user;

    /**
     * @return Account|null
     */
    public function getAccount(): ?Account
    {
        return $this->account;
    }

    /**
     * @param  Account|null  $account
     *
     * @return $this
     */
    public function setAccount(?Account $account): self
    {
        $this->account = $account;

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

}
