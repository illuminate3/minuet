<?php

declare(strict_types=1);

namespace App\Entity;

use App\Entity\Trait\CreatedAtTrait;
use App\Entity\Traits\EntityIdTrait;
use App\Repository\ThreadRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ThreadRepository::class)]
class Thread
{

    use EntityIdTrait;
    use CreatedAtTrait;

    #[ORM\Column(nullable: true, options: ['default' => 0])]
    private ?bool $isClosed = null;

    #[ORM\Column(nullable: true, options: ['default' => 0])]
    private ?bool $isPin = null;

    #[ORM\Column(type: Types::SMALLINT, nullable: true, options: ['default' => 0])]
    private ?int $totalMessages = null;

    #[ORM\ManyToOne(inversedBy: 'threads')]
    private ?Product $product = null;

    #[ORM\ManyToOne(inversedBy: 'threads')]
    private ?User $user = null;

    #[ORM\OneToMany(mappedBy: 'thread', targetEntity: Message::class)]
    private Collection $messages;

    #[ORM\ManyToOne(inversedBy: 'threads')]
    private ?Account $account = null;

    public function __construct()
    {
        $this->messages = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function isIsClosed(): ?bool
    {
        return $this->isClosed;
    }

    public function setIsClosed(?bool $isClosed): self
    {
        $this->isClosed = $isClosed;

        return $this;
    }

    public function isIsPin(): ?bool
    {
        return $this->isPin;
    }

    public function setIsPin(?bool $isPin): self
    {
        $this->isPin = $isPin;

        return $this;
    }

    public function getTotalMessages(): ?int
    {
        return $this->totalMessages;
    }

    public function setTotalMessages(?int $totalMessages): self
    {
        $this->totalMessages = $totalMessages;

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
            $message->setThread($this);
        }

        return $this;
    }

    public function removeMessage(Message $message): self
    {
        if ($this->messages->removeElement($message)) {
            // set the owning side to null (unless already changed)
            if ($message->getThread() === $this) {
                $message->setThread(null);
            }
        }

        return $this;
    }

    public function getAccount(): ?Account
    {
        return $this->account;
    }

    public function setAccount(?Account $account): self
    {
        $this->account = $account;

        return $this;
    }
}
