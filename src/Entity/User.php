<?php

declare(strict_types=1);

namespace App\Entity;

use App\Entity\Trait\CreatedAtTrait;
use App\Entity\Traits\EntityIdTrait;
use App\Repository\UserRepository;
use DateTime;
use DateTimeInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Table(name: 'users')]
#[ORM\Entity(repositoryClass: UserRepository::class)]
#[UniqueEntity('email')]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{

//    use CreatedAtTrait;
    use EntityIdTrait;

    /**
     * Requests older than this many seconds will be considered expired.
     */
    public const RETRY_TTL = 3600;

    /**
     * Maximum time that the confirmation token will be valid.
     */
    public const TOKEN_TTL = 43200;

    #[ORM\Column(type: Types::STRING, unique: true)]
    #[Assert\NotBlank]
    #[Assert\Email]
    private ?string $email;

    #[ORM\OneToMany(targetEntity: User::class, mappedBy: 'dealer')]
    private $staffUser;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'staffUsers')]
    #[ORM\JoinColumn(name: "dealer_id", referencedColumnName: "id")]
    private $dealer;

    #[ORM\Column(type: Types::STRING, length: 255, nullable: true)]
    private ?string $password = null;

    #[ORM\Column(type: Types::JSON)]
    private array $roles = [];

    #[ORM\Column(type: Types::STRING, length: 255, nullable: true)]
    private ?string $confirmation_token = null;

    #[ORM\Column(type: Types::STRING, length: 255, nullable: true)]
    private ?string $stripe_customer_id;

    #[ORM\Column(type: Types::STRING, length: 255, nullable: true)]
    private ?string $stripe_subscription_id;

    #[ORM\Column(type: Types::DATETIMETZ_MUTABLE, nullable: true)]
    private ?DateTimeInterface $password_requested_at;

    #[ORM\OneToOne(mappedBy: 'user', targetEntity: Profile::class, cascade: ['persist', 'remove'])]
    private ?Profile $profile;

    #[ORM\Column(type: Types::DATETIMETZ_MUTABLE, nullable: true)]
    private ?DateTime $emailVerifiedAt = null;

    #[ORM\Column(type: Types::BOOLEAN, length: 1, nullable: true)]
    private bool $isVerified = false;

    #[ORM\Column(nullable: true)]
    private ?bool $isAccount = null;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: Thread::class)]
    private Collection $threads;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: Message::class)]
    private Collection $messages;

    private ?string $role = '';

//    private ArrayCollection $properties;

    public function __construct()
    {
//        $this->properties = new ArrayCollection();
        $this->threads = new ArrayCollection();
        $this->messages = new ArrayCollection();
        $this->staffUser = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStaffUser()
    {
        return $this->staffUser;
    }

    public function getDealer(): ?self
    {
        return $this->dealer;
    }

    public function setDealer(?self $dealer): self
    {
        $this->dealer = $dealer;
        return $this;
    }

    public function getUserIdentifier(): string
    {
        return $this->email;
    }

    public function getfirstName(): ?string
    {
        return $this->first_name;
    }

    public function setfirstName(string $email): void
    {
        $this->first_name = $first_name;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        // $this->password = $password;
        if (!is_null($password)) {
            $this->password = $password;
        }
        return $this;
    }

    /**
     * Returns the roles or permissions granted to the user for security.
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantees that a user always has at least one role for security
        if (empty($roles)) {
            $roles[] = 'ROLE_USER';
            $roles[] = 'ROLE_ADMIN';
            $roles[] = 'ROLE_BUYER';
            $roles[] = 'ROLE_DEALER';
            $roles[] = 'ROLE_STAFF';
        }
        return array_unique($roles);
    }

    public function setRoles(array $roles): void
    {
        $this->roles = $roles;
    }

    /**
     * Returns the salt that was originally used to encode the password.
     */
    public function getSalt(): ?string
    {
        // See "Do you need to use a Salt?" at https://symfony.com/doc/current/cookbook/security/entity_provider.html
        // we're using bcrypt in security.yml to encode the password, so
        // the salt value is built-in, and you don't have to generate one
        return null;
    }

    /**
     * Removes sensitive data from the user.
     */
    public function eraseCredentials(): void
    {
        // if you had a plainPassword property, you'd nullify it here
        // $this->plainPassword = null;
    }

    public function __serialize(): array
    {
        // add $this->salt too if you don't use Bcrypt or Argon2i
        return [$this->id, $this->email, $this->password];
    }

    public function __unserialize(array $data): void
    {
        // add $this->salt too if you don't use Bcrypt or Argon2i
        [$this->id, $this->email, $this->password] = $data;
    }

    public function getConfirmationToken(): ?string
    {
        return $this->confirmation_token;
    }

    public function setConfirmationToken(?string $confirmation_token): self
    {
        $this->confirmation_token = $confirmation_token;

        return $this;
    }

    public function getPasswordRequestedAt(): ?DateTimeInterface
    {
        return $this->password_requested_at;
    }

    public function setPasswordRequestedAt(?DateTimeInterface $password_requested_at): self
    {
        $this->password_requested_at = $password_requested_at;

        return $this;
    }

    /**
     * Checks whether the password reset request has expired.
     */
    public function isPasswordRequestNonExpired(int $ttl): bool
    {
        return $this->getPasswordRequestedAt() instanceof DateTime
            && $this->getPasswordRequestedAt()->getTimestamp() + $ttl > time();
    }

    public function getProfile(): ?Profile
    {
        return $this->profile;
    }

    public function setProfile(Profile $profile): self
    {
        // set the owning side of the relation if necessary
        if ($profile->getUser() !== $this) {
            $profile->setUser($this);
        }

        $this->profile = $profile;

        return $this;
    }

    public function getIsVerified(): ?bool
    {
        return $this->isVerified;
    }

    public function setIsVerified(bool $isVerified): self
    {
        $this->isVerified = $isVerified;

        return $this;
    }

    public function getStripeCustomerId(): ?string
    {
        return $this->stripe_customer_id;
    }

    public function setStripeCustomerId(string $stripe_customer_id): self
    {
        $this->stripe_customer_id = $stripe_customer_id;

        return $this;
    }

    public function getStrSubscriptionId(): ?string
    {
        return $this->stripe_subscription_id;
    }

    public function setStrSubscriptionId(string $stripe_subscription_id): self
    {
        $this->stripe_subscription_id = $stripe_subscription_id;

        return $this;
    }

    public function isVerified(): bool
    {
        return $this->emailVerifiedAt !== null;
    }

    public function getEmailVerifiedAt(): ?DateTime
    {
        return $this->emailVerifiedAt;
    }

    public function setEmailVerifiedAt(?DateTime $dateTime): self
    {
        $this->emailVerifiedAt = $dateTime;

        return $this;
    }

    public function getIsAccount(): ?bool
    {
        return $this->isAccount ? true : false;
    }

    public function setIsAccount(?bool $isAccount): self
    {
        $this->isAccount = $isAccount;

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
            $thread->setUser($this);
        }

        return $this;
    }

    public function removeThread(Thread $thread): self
    {
        if ($this->threads->removeElement($thread)) {
            // set the owning side to null (unless already changed)
            if ($thread->getUser() === $this) {
                $thread->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Message>
     */
    public function getMessages(): Collection
    {
        return $this->messages;
    }

    public function addMessage(Message $message): self
    {
        if (!$this->messages->contains($message)) {
            $this->messages->add($message);
            $message->setUser($this);
        }

        return $this;
    }

    public function removeMessage(Message $message): self
    {
        if ($this->messages->removeElement($message)) {
            // set the owning side to null (unless already changed)
            if ($message->getUser() === $this) {
                $message->setUser(null);
            }
        }

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }
}
