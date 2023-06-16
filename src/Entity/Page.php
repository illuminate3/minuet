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

    /**
     * @return string|null
     */
    public function getTitle(): ?string
    {
        return $this->title;
    }

    /**
     * @param  string  $title
     *
     * @return $this
     */
    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * @param  string  $description
     *
     * @return $this
     */
    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getSlug(): ?string
    {
        return $this->slug;
    }

    /**
     * @param  string  $slug
     *
     * @return $this
     */
    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getContent(): ?string
    {
        return $this->content;
    }

    /**
     * @param  string  $content
     *
     * @return $this
     */
    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }

    /**
     * @return bool|null
     */
    public function getShowInMenu(): ?bool
    {
        return $this->show_in_menu;
    }

    /**
     * @param  bool  $show_in_menu
     *
     * @return $this
     */
    public function setShowInMenu(bool $show_in_menu): self
    {
        $this->show_in_menu = $show_in_menu;

        return $this;
    }

    /**
     * @return bool|null
     */
    public function getPublish(): ?bool
    {
        return $this->publish;
    }

    /**
     * @param  bool  $publish
     *
     * @return $this
     */
    public function setPublish(bool $publish): self
    {
        $this->publish = $publish;

        return $this;
    }

    /**
     * @return string
     */
    public function getLocale(): string
    {
        return $this->locale;
    }

    /**
     * @param  string  $locale
     *
     * @return $this
     */
    public function setLocale(string $locale): self
    {
        $this->locale = $locale;

        return $this;
    }

}
