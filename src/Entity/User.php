<?php

declare(strict_types=1);

namespace App\Entity;

use App\Entity\Trait\CreatedAtTrait;
use App\Entity\Trait\EntityIdTrait;
use App\Entity\Trait\ModifiedAtTrait;
use App\Repository\UserRepository;
use DateTimeImmutable;
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

    use EntityIdTrait;
    use CreatedAtTrait;
    use ModifiedAtTrait;

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
    private string $email;

    #[ORM\Column(type: Types::STRING, length: 255, nullable: true)]
    private ?string $password = null;

    #[ORM\Column(type: Types::JSON)]
    private array $roles = [];

    #[ORM\Column(type: Types::STRING, length: 255, nullable: true)]
    private ?string $confirmation_token = null;

    #[ORM\Column(type: Types::DATETIME_IMMUTABLE, nullable: true)]
    private ?DateTimeInterface $password_requested_at;

    #[ORM\Column(type: Types::DATETIME_IMMUTABLE, nullable: true)]
    private ?DateTimeInterface $emailVerifiedAt = null;

    #[ORM\Column(type: Types::BOOLEAN, length: 1, nullable: true, options: ['default' => 0])]
    private bool $isVerified = false;

    #[ORM\Column(nullable: true)]
    private ?bool $isAccount = null;

    #[ORM\Column(type: Types::STRING, length:10, nullable:true, options:['default'=>'active'])]
    private ?string $status;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: Thread::class)]
    private Collection $threads;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: Message::class)]
    private Collection $messages;


    private ?string $role = '';

//    private ArrayCollection $properties;
    #[ORM\OneToOne(mappedBy: 'user', targetEntity: Profile::class, cascade: ['persist', 'remove'])]
    private ?Profile $profile;

    public function __construct()
    {
        $this->threads = new ArrayCollection();
        $this->messages = new ArrayCollection();
    }

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getUserIdentifier(): string
    {
        return $this->email;
    }

    /**
     * @return string|null
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }

    /**
     * @param  string  $email
     *
     * @return void
     */
    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    /**
     * @return string|null
     */
    public function getPassword(): ?string
    {
        return $this->password;
    }

    /**
     * @param  string  $password
     *
     * @return void
     */
    public function setPassword(string $password): void
    {
        $this->password = $password;
    }

    /**
     * @return array
     */
    public function getRolesNew(): array
    {
        $roles = $this->roles;
        // guarantees that a user always has at least one role for security
        if (empty($roles)) {
            $roles[] = 'ROLE_ADMIN';
            $roles[] = 'ROLE_BUYER';
            $roles[] = 'ROLE_SELLER';
            $roles[] = 'ROLE_DEALER';
            $roles[] = 'ROLE_STAFF';
            $roles[] = 'ROLE_USER';
        }
        return array_unique($roles);
    }

    /**
     * @return array|string[]
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantees that a user always has at least one role for security
        if (empty($roles)) {
            $roles[] = 'ROLE_USER';
        }

        return array_unique($roles);
    }

    /**
     * @param  array  $roles
     *
     * @return void
     */
    public function setRoles(array $roles): void
    {
        $this->roles = $roles;
    }

    /**
     * Returns the salt that was originally used to encode the password.
     *
     * @return string|null
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
     *
     * @return void
     */
    public function eraseCredentials(): void
    {
        // if you had a plainPassword property, you'd nullify it here
        // $this->plainPassword = null;
    }

    /**
     * @return array
     */
    public function __serialize(): array
    {
        // add $this->salt too if you don't use Bcrypt or Argon2i
        return [$this->id, $this->email, $this->password];
    }

    /**
     * @param  array  $data
     *
     * @return void
     */
    public function __unserialize(array $data): void
    {
        // add $this->salt too if you don't use Bcrypt or Argon2i
        [$this->id, $this->email, $this->password] = $data;
    }

    /**
     * @return string|null
     */
    public function getConfirmationToken(): ?string
    {
        return $this->confirmation_token;
    }

    /**
     * @param  string|null  $confirmation_token
     *
     * @return $this
     */
    public function setConfirmationToken(?string $confirmation_token): self
    {
        $this->confirmation_token = $confirmation_token;

        return $this;
    }

    /**
     * @return DateTimeInterface|null
     */
    public function getPasswordRequestedAt(): ?DateTimeInterface
    {
        return $this->password_requested_at;
    }

    /**
     * @param  DateTimeInterface|null  $password_requested_at
     *
     * @return $this
     */
    public function setPasswordRequestedAt(?DateTimeInterface $password_requested_at): self
    {
        $this->password_requested_at = $password_requested_at;

        return $this;
    }

    /**
     * Checks whether the password reset request has expired.
     *
     * @param  int  $ttl
     *
     * @return bool
     */
    public function isPasswordRequestNonExpired(int $ttl): bool
    {
        return $this->getPasswordRequestedAt() instanceof DateTimeImmutable
            && $this->getPasswordRequestedAt()->getTimestamp() + $ttl > time();
    }

    /**
     * @return Profile|null
     */
    public function getProfile(): ?Profile
    {
        return $this->profile;
    }

    /**
     * @param  Profile  $profile
     *
     * @return $this
     */
    public function setProfile(Profile $profile): self
    {
        // set the owning side of the relation if necessary
        if ($profile->getUser() !== $this) {
            $profile->setUser($this);
        }

        $this->profile = $profile;

        return $this;
    }

    /**
     * @return bool|null
     */
    public function getIsVerified(): ?bool
    {
        return $this->isVerified;
    }

    /**
     * @param  bool  $isVerified
     *
     * @return $this
     */
    public function setIsVerified(bool $isVerified): self
    {
        $this->isVerified = $isVerified;

        return $this;
    }

    /**
     * @return bool
     */
    public function isVerified(): bool
    {
        return $this->emailVerifiedAt !== null;
    }

    /**
     * @return DateTimeInterface|null
     */
    public function getEmailVerifiedAt(): ?DateTimeInterface
    {
        return $this->emailVerifiedAt;
    }

    /**
     * @param  DateTimeInterface|null  $dateTime
     *
     * @return $this
     */
    public function setEmailVerifiedAt(?DateTimeInterface $dateTime): self
    {
        $this->emailVerifiedAt = $dateTime;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getStatus(): ?string
    {
        return $this->status;
    }

    /**
     * @param  string  $status
     *
     * @return string
     */
    public function setStatus(string $status): string
    {
      return  $this->status = $status;
    }

    /**
     * @return bool|null
     */
    public function getIsAccount(): ?bool
    {
        return (bool) $this->isAccount;
    }

    /**
     * @param  bool|null  $isAccount
     *
     * @return $this
     */
    public function setIsAccount(?bool $isAccount): self
    {
        $this->isAccount = $isAccount;

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
            $thread->setUser($this);
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
            if ($thread->getUser() === $this) {
                $thread->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection
     */
    public function getMessages(): Collection
    {
        return $this->messages;
    }

    /**
     * @param  Message  $message
     *
     * @return $this
     */
    public function addMessage(Message $message): self
    {
        if (!$this->messages->contains($message)) {
            $this->messages->add($message);
            $message->setUser($this);
        }

        return $this;
    }

    /**
     * @param  Message  $message
     *
     * @return $this
     */
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

}
