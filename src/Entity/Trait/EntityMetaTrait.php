<?php

declare(strict_types=1);

namespace App\Entity\Trait;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

trait EntityMetaTrait
{
    #[ORM\Column(type: Types::STRING, length: 255, nullable: true)]
    private ?string $meta_title;

    #[ORM\Column(type: Types::STRING, length: 255, nullable: true)]
    private ?string $meta_description;


    /**
     * @return string|null
     */
    public function getMetaTitle(): ?string
    {
        return $this->meta_title;
    }

    /**
     * @param  string|null  $meta_title
     *
     * @return EntityMetaTrait
     */
    public function setMetaTitle(?string $meta_title): self
    {
        $this->meta_title = $meta_title;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getMetaDescription(): ?string
    {
        return $this->meta_description;
    }

    /**
     * @param  string|null  $meta_description
     *
     * @return EntityMetaTrait
     */
    public function setMetaDescription(?string $meta_description): self
    {
        $this->meta_description = $meta_description;

        return $this;
    }

}
