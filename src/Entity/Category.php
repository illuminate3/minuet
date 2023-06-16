<?php

declare(strict_types=1);

namespace App\Entity;

use App\Entity\Trait\EntityIdTrait;
use App\Entity\Trait\SlugTrait;
use App\Repository\CategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CategoryRepository::class)]
class Category
{
    use EntityIdTrait;
    use SlugTrait;

    #[ORM\Column(type: 'string', length: 100)]
    private ?string $name;

    #[ORM\Column(type: 'integer', nullable: true)]
    private ?int $categoryOrder;

    #[ORM\ManyToOne(targetEntity: self::class, inversedBy: 'category')]
    #[ORM\JoinColumn(onDelete: 'CASCADE')]
    private ?Category $parent;

    #[ORM\OneToMany(mappedBy: 'parent', targetEntity: self::class)]
    private $category;

    #[ORM\OneToMany(mappedBy: 'category', targetEntity: Product::class)]
    private $product;

    public function __construct()
    {
        $this->category = new ArrayCollection();
        $this->product = new ArrayCollection();
    }

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param  string  $name
     *
     * @return $this
     */
    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return int|null
     */
    public function getCategoryOrder(): ?int
    {
        return $this->categoryOrder;
    }

    /**
     * @param  int  $categoryOrder
     *
     * @return $this
     */
    public function setCategoryOrder(int $categoryOrder): self
    {
        $this->categoryOrder = $categoryOrder;

        return $this;
    }

    /**
     * @return $this|null
     */
    public function getParent(): ?self
    {
        return $this->parent;
    }

    /**
     * @param  Category|null  $parent
     *
     * @return $this
     */
    public function setParent(?self $parent): self
    {
        $this->parent = $parent;

        return $this;
    }

    /**
     * @return Collection
     */
    public function getCategory(): Collection
    {
        return $this->category;
    }

    /**
     * @param  Category  $category
     *
     * @return $this
     */
    public function addCategory(self $category): self
    {
        if (!$this->category->contains($category)) {
            $this->category[] = $category;
            $category->setParent($this);
        }

        return $this;
    }

    /**
     * @param  Category  $category
     *
     * @return $this
     */
    public function removeCategory(self $category): self
    {
        if ($this->category->removeElement($category)) {
            // set the owning side to null (unless already changed)
            if ($category->getParent() === $this) {
                $category->setParent(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection
     */
    public function getProduct(): Collection
    {
        return $this->product;
    }

    /**
     * @param  Product  $product
     *
     * @return $this
     */
    public function addProduct(Product $product): self
    {
        if (!$this->product->contains($product)) {
            $this->product[] = $product;
            $product->setCategory($this);
        }

        return $this;
    }

    /**
     * @param  Product  $product
     *
     * @return $this
     */
    public function removeProduct(Product $product): self
    {
        if ($this->product->removeElement($product)) {
            // set the owning side to null (unless already changed)
            if ($product->getCategory() === $this) {
                $product->setCategory(null);
            }
        }

        return $this;
    }

}
