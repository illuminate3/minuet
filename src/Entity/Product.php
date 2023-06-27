<?php

declare(strict_types=1);

namespace App\Entity;

use App\Entity\Trait\CreatedAtTrait;
use App\Entity\Trait\EntityIdTrait;
use App\Entity\Trait\ModifiedAtTrait;
use App\Entity\Trait\SlugTrait;
use App\Repository\ProductRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Table]
// #[UniqueEntity(['title'])]
// #[ORM\UniqueConstraint(name: 'slug_title_unique_key', columns: ['slug', 'title'])]
#[ORM\UniqueConstraint(name: 'slug_title_unique_key', columns: ['slug'])]
#[ORM\Entity(repositoryClass: ProductRepository::class)]
class Product
{

    use EntityIdTrait;
    use CreatedAtTrait;
    use ModifiedAtTrait;
    use SlugTrait;

    #[ORM\Column(type: Types::TEXT, length: 255)]
    private ?string $title = '';

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description;

   /**
    * @ORM\Column(type="decimal", precision=7, scale=2)
    */
    #[ORM\Column(type: Types::INTEGER, nullable: false)]
    private $price = 0;

//     #[ORM\Column(type: 'integer')]
//     private ?stringint $price;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $vin = '';

    #[ORM\ManyToOne(inversedBy: 'products')]
    private ?Account $account;

    #[ORM\OneToMany(mappedBy: 'product', targetEntity: Thread::class, cascade: ['persist', 'remove'])]
    private Collection $threads;

    #[ORM\OneToMany(mappedBy: 'product',  targetEntity: Image::class, cascade: ['persist', 'remove'])]
    #[ORM\OrderBy(['sortOrder' => 'DESC'])]
    private Collection $images;

    #[ORM\ManyToOne(targetEntity: Category::class, inversedBy: 'product')]
    #[ORM\JoinColumn(nullable: true)]
    private ?Category $category;

    public function __construct()
    {
        $this->threads = new ArrayCollection();
        $this->images = new ArrayCollection();
        // $this->productTrims = new ArrayCollection();
    }

    /**
     * @return string|null
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param $title
     *
     * @return $this
     */
    public function setTitle( $title): self
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param $description
     *
     * @return $this
     */
    public function setDescription( $description): self
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return int
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * @param  int  $price
     *
     * @return $this
     */
    public function setPrice(int $price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getVin()
    {
        return $this->vin;
    }

    /**
     * @param $vin
     *
     * @return $this
     */
    public function setVin( $vin): self
    {
        $this->vin = $vin;

        return $this;
    }

    /**
     * @return Category|null
     */
    public function getCategory(): ?Category
    {
        return $this->category;
    }

    /**
     * @param  Category|null  $category
     *
     * @return $this
     */
    public function setCategory(?Category $category): self
    {
        $this->category = $category;

        return $this;
    }

    /**
     * @return Collection
     */
    public function getOrderDetail(): Collection
    {
        return $this->orderDetail;
    }

    /**
     * @param  OrderDetail  $orderDetail
     *
     * @return $this
     */
    public function addOrdersDetail(OrderDetail $orderDetail): self
    {
        if (!$this->orderDetail->contains($orderDetail)) {
            $this->orderDetail[] = $orderDetail;
            $orderDetail->setProduct($this);
        }

        return $this;
    }

    /**
     * @param  OrderDetail  $orderDetail
     *
     * @return $this
     */
    public function removeOrdersDetail(OrderDetail $orderDetail): self
    {
        if ($this->orderDetail->removeElement($orderDetail)) {
            // set the owning side to null (unless already changed)
            if ($orderDetail->getProduct() === $this) {
                $orderDetail->setProduct(null);
            }
        }

        return $this;
    }

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
    public function setAccount(?Account $account)
    {
        $this->account = $account;

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
            $thread->setProduct($this);
        }

        return $this;
    }

    // public function removeThread(Thread $thread): self
    // {
    //     if ($this->threads->removeElement($thread)) {
    //         // set the owning side to null (unless already changed)
    //         if ($thread->getProduct() === $this) {
    //             $thread->setProduct(null);
    //         }
    //     }

    //     return $this;
    // }

    /**
     * @return Collection
     */
    public function getImages(): Collection
    {
        return $this->images;
    }

    public function addImage(Image $image): self
    {
        if (!$this->images->contains($image)) {
            $this->images->add($image);
            $image->setProduct($this);
        }

        return $this;
    }

    /**
     * @param  Image  $image
     *
     * @return $this
     */
    public function removeImage(Image $image): self
    {
        if ($this->images->removeElement($image)) {
            // set the owning side to null (unless already changed)
            if ($image->getProduct() === $this) {
                $image->setProduct(null);
            }
        }

        return $this;
    }

}
