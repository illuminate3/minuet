<?php

declare(strict_types=1);

namespace App\Entity;

use App\Entity\Trait\EntityIdTrait;
use App\Repository\MakeModelRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MakeModelRepository::class)]
class MakeModel
{
    use EntityIdTrait;

    #[ORM\Column(length: 4)]
    private ?string $year = null;

    #[ORM\Column(length: 45)]
    private ?string $make = null;

    #[ORM\Column(length: 255)]
    private ?string $model = null;

    #[ORM\Column(length: 255)]
    private ?string $body_style = null;

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
    public function getYear(): ?string
    {
        return $this->year;
    }

    /**
     * @param  string  $year
     *
     * @return $this
     */
    public function setYear(string $year): self
    {
        $this->year = $year;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getMake(): ?string
    {
        return $this->make;
    }

    /**
     * @param  string  $make
     *
     * @return $this
     */
    public function setMake(string $make): self
    {
        $this->make = $make;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getModel(): ?string
    {
        return $this->model;
    }

    /**
     * @param  string  $model
     *
     * @return $this
     */
    public function setModel(string $model): self
    {
        $this->model = $model;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getBodyStyle(): ?string
    {
        return $this->body_style;
    }

    /**
     * @param  string  $body_style
     *
     * @return $this
     */
    public function setBodyStyle(string $body_style): self
    {
        $this->body_style = $body_style;

        return $this;
    }

}
