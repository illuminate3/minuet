<?php

declare(strict_types=1);

namespace App\Entity;

use App\Entity\Trait\CreatedAtTrait;
use App\Entity\Trait\EntityIdTrait;
use App\Entity\Trait\ModifiedAtTrait;
use App\Repository\ProductTrimsRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Table]
#[ORM\Entity(repositoryClass: ProductTrimsRepository::class)]

class ProductTrims
{
    use EntityIdTrait;
    use CreatedAtTrait;
    use ModifiedAtTrait;

    #[ORM\Column(type: Types::INTEGER, nullable: true)]
    private ?int $trim_id;

    #[ORM\Column(type: Types::INTEGER, nullable: true)]
    private ?int $make_model_id;

    #[ORM\Column(type: Types::INTEGER, nullable: true)]
    private ?int $product_id;

    #[ORM\Column(type: Types::INTEGER, nullable: true)]
    private ?int $year;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $name;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description;

    #[ORM\Column(type: Types::INTEGER, nullable: true)]
    private ?int $msrp;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?int $invoice;

    /** Many features have one product. This is the owning side. */
    // #[ManyToOne(targetEntity: Product::class, inversedBy: 'product_trims')]
    // #[JoinColumn(name: 'product_id', referencedColumnName: 'id')]
    // private Product|null $product = null;

    public function __construct($arraData)
    {
        $this->trim_id = $arraData['id'];
        $this->make_model_id = $arraData['make_model_id'];
        $this->product_id = $arraData['product_id'];
        $this->year = $arraData['year'];
        $this->name = $arraData['name'];
        $this->description = $arraData['description'];
        $this->msrp = $arraData['msrp'];
        $this->invoice = $arraData['invoice'];
        $this->created_at = $arraData['created_at'];
        $this->modified_at = $arraData['created_at'];
    }


    /**
     * @return mixed|string|null
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param $name
     *
     * @return $this
     */
    public function setName( $name): self
    {
        $this->name = $name;

        return $this;
    }

}
