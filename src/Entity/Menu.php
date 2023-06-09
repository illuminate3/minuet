<?php

declare(strict_types=1);

namespace App\Entity;

use App\Entity\Trait\EntityIdTrait;
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
     * @return int|null
     */
    public function getSortOrder(): ?int
    {
        return $this->sort_order;
    }

    /**
     * @param  int|null  $sort_order
     *
     * @return $this
     */
    public function setSortOrder(?int $sort_order): self
    {
        $this->sort_order = $sort_order;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getUrl(): ?string
    {
        return $this->url;
    }

    /**
     * @param  string  $url
     *
     * @return $this
     */
    public function setUrl(string $url): self
    {
        $this->url = $url;

        return $this;
    }

    /**
     * @return bool|null
     */
    public function getIsSlug(): ?bool
    {
        return $this->isSlug;
    }

    /**
     * @param  bool|null  $isSlug
     *
     * @return $this
     */
    public function setIsSlug(?bool $isSlug): self
    {
        $this->isSlug = $isSlug;

        return $this;
    }

    /**
     * @return bool|null
     */
    public function getNofollow(): ?bool
    {
        return $this->nofollow;
    }

    /**
     * @param  bool|null  $nofollow
     *
     * @return $this
     */
    public function setNofollow(?bool $nofollow): self
    {
        $this->nofollow = $nofollow;

        return $this;
    }

    /**
     * @return bool|null
     */
    public function getNewTab(): ?bool
    {
        return $this->new_tab;
    }

    /**
     * @param  bool|null  $new_tab
     *
     * @return $this
     */
    public function setNewTab(?bool $new_tab): self
    {
        $this->new_tab = $new_tab;

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
