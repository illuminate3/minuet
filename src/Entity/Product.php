<?php

declare(strict_types=1);

namespace App\Entity;

use App\Entity\Trait\CreatedAtTrait;
use App\Entity\Trait\ModifiedAtTrait;
use App\Entity\Trait\SlugTrait;
use App\Entity\Traits\EntityIdTrait;
use App\Repository\ProductRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\DecimalType;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\InverseJoinColumn;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\JoinTable;
use Doctrine\ORM\Mapping\ManyToMany;
use Doctrine\ORM\Mapping\OneToMany;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

#[ORM\Table]
// #[UniqueEntity(['title'])]
// #[ORM\UniqueConstraint(name: 'slug_title_unique_key', columns: ['slug', 'title'])]
#[ORM\UniqueConstraint(name: 'slug_title_unique_key', columns: ['slug'])]
#[ORM\Entity(repositoryClass: ProductRepository::class)]
class Product
{
    use CreatedAtTrait;
    use ModifiedAtTrait;
    use SlugTrait;
    use EntityIdTrait;

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

    #[ORM\OneToMany(mappedBy: 'product', targetEntity: Thread::class)]
    private Collection $threads;

    #[ORM\OneToMany(mappedBy: 'product',  targetEntity: Image::class)]
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

    public function getTitle()
    {
        return $this->title;
    }

    public function setTitle( $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function setDescription( $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getPrice()
    {
        return $this->price;
    }

    public function setPrice(int $price)
    {
        $this->price = $price;

        return $this;
    }

    public function getVin()
    {
        return $this->vin;
    }

    public function setVin( $vin): self
    {
        $this->vin = $vin;

        return $this;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): self
    {
        $this->category = $category;

        return $this;
    }

    /**
     * @return Collection|OrderDetail[]
     */
    public function getOrderDetail(): Collection
    {
        return $this->orderDetail;
    }

    public function addOrdersDetail(OrderDetail $orderDetail): self
    {
        if (!$this->orderDetail->contains($orderDetail)) {
            $this->orderDetail[] = $orderDetail;
            $orderDetail->setProduct($this);
        }

        return $this;
    }

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

    public function getAccount(): ?Account
    {
        return $this->account;
    }

    public function setAccount(?Account $account)
    {
        $this->account = $account;

        return $this;
    }

    // /**
    //  * @return Collection<int, Thread>
    //  */
    public function getThreads(): Collection
    {
        return $this->threads;
    }

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
     * @return Collection<int, Image>
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
