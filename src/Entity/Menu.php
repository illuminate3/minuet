<?php

declare(strict_types=1);

namespace App\Entity;

use App\Entity\Trait\CreatedAtTrait;
use App\Entity\Traits\EntityIdTrait;
use App\Repository\MenuRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

#[ORM\Table]
#[UniqueEntity(['url'])]
#[ORM\UniqueConstraint(name: 'url_title_unique_key', columns: ['url', 'title'])]
#[ORM\Entity(repositoryClass: MenuRepository::class)]
//#[ORM\UniqueConstraint(name: 'url_locale_unique_key', columns: ['url', 'locale'])]
//#[ORM\Entity(repositoryClass: 'App\Repository\MenuRepository')]
//#[UniqueEntity(['url', 'locale'])]
class Menu
{
//    use CreatedAtTrait;
    use EntityIdTrait;


    #[ORM\Column(type: Types::STRING, length: 255)]
    private ?string $title;

    #[ORM\Column(type: Types::STRING, length: 2, options: ['default' => 'en'])]
    private string $locale = 'en';

    #[ORM\Column(type: Types::SMALLINT, nullable: true)]
    private ?int $sort_order;

    #[ORM\Column(type: Types::STRING, length: 255)]
    private ?string $url = '';

    #[ORM\Column(type: Types::BOOLEAN, nullable: true)]
    private ?bool $isSlug;

    #[ORM\Column(type: Types::BOOLEAN, nullable: true)]
    private ?bool $nofollow;

    #[ORM\Column(type: Types::BOOLEAN, nullable: true)]
    private ?bool $new_tab;

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getSortOrder(): ?int
    {
        return $this->sort_order;
    }

    public function setSortOrder(?int $sort_order): self
    {
        $this->sort_order = $sort_order;

        return $this;
    }

    public function getUrl(): ?string
    {
        return $this->url;
    }

    public function setUrl(string $url): self
    {
        $this->url = $url;

        return $this;
    }

    public function getIsSlug(): ?bool
    {
        return $this->isSlug;
    }

    public function setIsSlug(?bool $isSlug): self
    {
        $this->isSlug = $isSlug;

        return $this;
    }

    public function getNofollow(): ?bool
    {
        return $this->nofollow;
    }

    public function setNofollow(?bool $nofollow): self
    {
        $this->nofollow = $nofollow;

        return $this;
    }

    public function getNewTab(): ?bool
    {
        return $this->new_tab;
    }

    public function setNewTab(?bool $new_tab): self
    {
        $this->new_tab = $new_tab;

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
