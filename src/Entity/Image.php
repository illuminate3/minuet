<?php

declare(strict_types=1);

namespace App\Entity;

use App\Entity\Trait\CreatedAtTrait;
use App\Entity\Traits\EntityIdTrait;
use App\Repository\ImageRepository;
use DateTimeImmutable;
use DateTimeInterface;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


#[ORM\Entity(repositoryClass: ImageRepository::class)]
class Image
{
    use EntityIdTrait;
    // use CreatedAtTrait;

    #[ORM\Column(type: Types::SMALLINT, nullable: true)]
    private ?int $sortOrder = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Assert\File(mimeTypes: ['image/*'])]
    private ?string $file = null;

    #[ORM\ManyToOne(inversedBy: 'images')]
    private ?Product $product = null;

    #[ORM\Column(type: 'datetime_immutable', options: ['default' => 'CURRENT_TIMESTAMP'])]
    private ?DateTimeImmutable $created_at;
    
    #[ORM\Column(type: 'datetime_immutable', options: ['default' => 'CURRENT_TIMESTAMP'])]
    private ?DateTimeImmutable $modified_at;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSortOrder(): ?int
    {
        return $this->sortOrder;
    }

    public function setSortOrder(?int $sortOrder): self
    {
        $this->sortOrder = $sortOrder;

        return $this;
    }

    public function getFile(): ?string
    {
        return $this->file;
    }

    public function setFile(?string $file): self
    {
        $this->file = $file;

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

    public function getCreatedAt(): ?DateTimeImmutable
    {
        return $this->created_at;
    }

    public function setCreatedAt(DateTimeImmutable $created_at): self
    {
        $this->created_at = $created_at;

        return $this;
    }

    public function getModifiedAt(): ?DateTimeImmutable
    {
        return $this->modified_at;
    }

    public function setModifiedAt(DateTimeImmutable $modified_at): self
    {
        $this->modified_at = $modified_at;

        return $this;
    }
}
