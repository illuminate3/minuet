<?php

declare(strict_types=1);

namespace App\Entity;

use App\Entity\Trait\EntityIdTrait;
use App\Repository\ImageRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


#[ORM\Entity(repositoryClass: ImageRepository::class)]
class Image
{
    use EntityIdTrait;

    #[ORM\Column(type: Types::SMALLINT, nullable: true)]
    private ?int $sortOrder = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Assert\File(mimeTypes: ['image/*'])]
    private ?string $file = null;

    #[ORM\ManyToOne(inversedBy: 'images')]
    private ?Product $product = null;

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return int|null
     */
    public function getSortOrder(): ?int
    {
        return $this->sortOrder;
    }

    /**
     * @param  int|null  $sortOrder
     *
     * @return $this
     */
    public function setSortOrder(?int $sortOrder): self
    {
        $this->sortOrder = $sortOrder;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getFile(): ?string
    {
        return $this->file;
    }

    /**
     * @param  string|null  $file
     *
     * @return $this
     */
    public function setFile(?string $file): self
    {
        $this->file = $file;

        return $this;
    }

    /**
     * @return Product|null
     */
    public function getProduct(): ?Product
    {
        return $this->product;
    }

    /**
     * @param  Product|null  $product
     *
     * @return $this
     */
    public function setProduct(?Product $product): self
    {
        $this->product = $product;

        return $this;
    }

}
