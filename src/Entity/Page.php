<?php

declare(strict_types=1);

namespace App\Entity;

use App\Entity\Trait\CreatedAtTrait;
use App\Entity\Trait\EntityIdTrait;
use App\Entity\Trait\ModifiedAtTrait;
use App\Repository\PageRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

#[ORM\Table]
#[UniqueEntity(['title'])]
#[ORM\UniqueConstraint(name: 'slug_title_unique_key', columns: ['slug', 'title'])]
#[ORM\Entity(repositoryClass: PageRepository::class)]
class Page
{

    use EntityIdTrait;
    use CreatedAtTrait;
    use ModifiedAtTrait;

    #[ORM\Column(type: Types::STRING, length: 255)]
    private ?string $title;

    #[ORM\Column(type: Types::STRING, length: 255)]
    private ?string $slug;

    #[ORM\Column(type: Types::STRING, length: 255, nullable: true)]
    private ?string $description;

    #[ORM\Column(type: Types::STRING, length: 2, options: ['default' => 'en'])]
    private string $locale = 'en';

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $content;

    #[ORM\Column(type: Types::BOOLEAN, nullable: true)]
    private ?bool $show_in_menu;

    #[ORM\Column(type: Types::BOOLEAN, nullable: true)]
    private ?bool $publish;

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

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getShowInMenu(): ?bool
    {
        return $this->show_in_menu;
    }

    public function setShowInMenu(bool $show_in_menu): self
    {
        $this->show_in_menu = $show_in_menu;

        return $this;
    }

    public function getPublish(): ?bool
    {
        return $this->publish;
    }

    public function setPublish(bool $publish): self
    {
        $this->publish = $publish;

        return $this;
    }

    public function getLocale(): string
    {
        return $this->locale;
    }

    public function setLocale(string $locale): self
    {
        $this->locale = $locale;

        return $this;
    }
}
