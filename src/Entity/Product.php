<?php

declare(strict_types=1);

namespace App\Entity;

use App\Entity\Trait\CreatedAtTrait;
use App\Entity\Trait\SlugTrait;
use App\Entity\Traits\EntityIdTrait;
use App\Repository\ProductRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;


#[ORM\Table]
//#[UniqueEntity(['title'])]
//#[ORM\UniqueConstraint(name: 'slug_title_unique_key', columns: ['slug', 'title'])]
#[ORM\Entity(repositoryClass: ProductRepository::class)]
class Product
{
//    use CreatedAtTrait;
    use SlugTrait;
    use EntityIdTrait;

//    #[ORM\Column(type: 'string', length: 255)]
//    #[Assert\NotBlank(message: 'Le nom du produit ne peut pas être vide')]
//    #[Assert\Length(
//        min: 8,
//        max: 200,
//        minMessage: 'Le titre doit faire au moins {{ limit }} caractères',
//        maxMessage: 'Le titre ne doit pas faire plus de {{ limit }} caractères'
//    )]
//    private $name;

    #[ORM\Column(type: Types::STRING, length: 255)]
    private ?string $title;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description;

//    #[ORM\Column(type: 'text')]
//    private $description;

//    /**
//     * @ORM\Column(type="decimal", precision=7, scale=2)
//     */
//    private $price = 0;

    #[ORM\Column(type: 'integer')]
    private $price;

    #[ORM\ManyToOne(targetEntity: Category::class, inversedBy: 'product')]
    #[ORM\JoinColumn(nullable: false)]
    private $category;

    #[ORM\OneToMany(mappedBy: 'product', targetEntity: Image::class, orphanRemoval: true, cascade: ['persist'])]
    private $image;

    #[ORM\OneToMany(mappedBy: 'product', targetEntity: OrderDetail::class)]
    private $orderDetail;

    #[ORM\ManyToOne(inversedBy: 'products')]
    private ?Account $account = null;

    public function __construct()
    {
        $this->image = new ArrayCollection();
        $this->orderDetail = new ArrayCollection();
        $this->created_at = new \DateTimeImmutable();
    }


    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getPrice(): ?int
    {
        return $this->price;
    }

    public function setPrice(int $price): self
    {
        $this->price = $price;

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
     * @return Collection|Image[]
     */
    public function getImage(): Collection
    {
        return $this->image;
    }

    public function addImage(Image $image): self
    {
        if (!$this->image->contains($image)) {
            $this->image[] = $image;
            $image->setProduct($this);
        }

        return $this;
    }

    public function removeImage(Image $image): self
    {
        if ($this->image->removeElement($image)) {
            // set the owning side to null (unless already changed)
            if ($image->getProduct() === $this) {
                $image->setProduct(null);
            }
        }

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

    public function setAccount(?Account $account): self
    {
        $this->account = $account;

        return $this;
    }
}
