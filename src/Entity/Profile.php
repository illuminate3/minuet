<?php

declare(strict_types=1);

namespace App\Entity;

use App\Entity\Trait\EntityIdTrait;
use App\Repository\ProfileRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProfileRepository::class)]
class Profile
{

    use EntityIdTrait;

    #[ORM\ManyToOne(inversedBy: 'user')]
    #[ORM\JoinColumn(name: 'user_id')]
    private ?User $user_id = null;

    #[ORM\Column(length: 40, nullable: true)]
    private ?string $first_name = null;

    #[ORM\Column(length: 40, nullable: true)]
    private ?string $last_name = null;

    #[ORM\Column(type: Types::STRING, length: 15, nullable: true)]
    private ?string $phone;

    #[ORM\OneToOne(inversedBy: 'profile', targetEntity: User::class, cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private $user;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $address_street = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $address_unit = null;

    #[ORM\Column(length: 2, nullable: true)]
    private ?string $state = null;

    #[ORM\Column(length: 20, nullable: true)]
    private ?string $city = null;

    #[ORM\Column(length: 10, nullable: true)]
    private ?string $post_code = null;

    #[ORM\Column(length: 40, nullable: true)]
    private ?string $display_email = null;

    #[ORM\Column(length: 40, nullable: true)]
    private ?string $website = null;

    #[ORM\Column(length: 100, nullable: true)]
    private ?string $facebook = null;

    #[ORM\Column(length: 100, nullable: true)]
    private ?string $twitter = null;

    #[ORM\Column(length: 100, nullable: true)]
    private ?string $linkedin = null;

    #[ORM\Column(length: 100, nullable: true)]
    private ?string $instagram = null;

    #[ORM\Column(length: 100, nullable: true)]
    private ?string $pinterest = null;

    #[ORM\Column(length: 100, nullable: true)]
    private ?string $youtube = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $banner = null;

    /**
     * @return string|null
     */
    public function getFullName(): ?string
    {
        if (!empty($this->first_name) && !empty($this->last_name)) {
            return $this->first_name . ', ' . $this->last_name;
        } else {
            return "";
        }
    }

    /**
     * @return string|null
     */
    public function getFirstName(): ?string
    {
        return $this->first_name;
    }

    /**
     * @param  string|null  $first_name
     *
     * @return $this
     */
    public function setFirstName(?string $first_name): self
    {
        $this->first_name = $first_name;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getLastName(): ?string
    {
        return $this->last_name;
    }

    /**
     * @param  string|null  $last_name
     *
     * @return $this
     */
    public function setLastName(?string $last_name): self
    {
        $this->last_name = $last_name;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getPhone(): ?string
    {
        return $this->phone;
    }

    /**
     * @param  string|null  $phone
     *
     * @return $this
     */
    public function setPhone(?string $phone): self
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * @return User|null
     */
    public function getUser(): ?User
    {
        return $this->user;
    }

    /**
     * @param  User  $user
     *
     * @return $this
     */
    public function setUser(User $user): self
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getAddressStreet(): ?string
    {
        return $this->address_street;
    }

    /**
     * @param  string|null  $address_street
     *
     * @return $this
     */
    public function setAddressStreet(?string $address_street): self
    {
        $this->address_street = $address_street;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getAddressUnit(): ?string
    {
        return $this->address_unit;
    }

    /**
     * @param  string|null  $address_unit
     *
     * @return $this
     */
    public function setAddressUnit(?string $address_unit): self
    {
        $this->address_unit = $address_unit;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getState(): ?string
    {
        return $this->state;
    }

    /**
     * @param  string|null  $state
     *
     * @return $this
     */
    public function setState(?string $state): self
    {
        $this->state = $state;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getCity(): ?string
    {
        return $this->city;
    }

    /**
     * @param  string|null  $city
     *
     * @return $this
     */
    public function setCity(?string $city): self
    {
        $this->city = $city;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getPostCode(): ?string
    {
        return $this->post_code;
    }

    /**
     * @param  string|null  $post_code
     *
     * @return $this
     */
    public function setPostCode(?string $post_code): self
    {
        $this->post_code = $post_code;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getDisplayEmail(): ?string
    {
        return $this->display_email;
    }

    /**
     * @param  string|null  $display_email
     *
     * @return $this
     */
    public function setDisplayEmail(?string $display_email): self
    {
        $this->display_email = $display_email;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getWebsite(): ?string
    {
        return $this->website;
    }

    /**
     * @param  string|null  $website
     *
     * @return $this
     */
    public function setWebsite(?string $website): self
    {
        $this->website = $website;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getFacebook(): ?string
    {
        return $this->facebook;
    }

    /**
     * @param  string|null  $facebook
     *
     * @return $this
     */
    public function setFacebook(?string $facebook): self
    {
        $this->facebook = $facebook;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getTwitter(): ?string
    {
        return $this->twitter;
    }

    /**
     * @param  string|null  $twitter
     *
     * @return $this
     */
    public function setTwitter(?string $twitter): self
    {
        $this->twitter = $twitter;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getLinkedin(): ?string
    {
        return $this->linkedin;
    }

    /**
     * @param  string|null  $linkedin
     *
     * @return $this
     */
    public function setLinkedin(?string $linkedin): self
    {
        $this->linkedin = $linkedin;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getInstagram(): ?string
    {
        return $this->instagram;
    }

    /**
     * @param  string|null  $instagram
     *
     * @return $this
     */
    public function setInstagram(?string $instagram): self
    {
        $this->instagram = $instagram;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getPinterest(): ?string
    {
        return $this->pinterest;
    }

    /**
     * @param  string|null  $pinterest
     *
     * @return $this
     */
    public function setPinterest(?string $pinterest): self
    {
        $this->pinterest = $pinterest;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getYoutube(): ?string
    {
        return $this->youtube;
    }

    /**
     * @param  string|null  $youtube
     *
     * @return $this
     */
    public function setYoutube(?string $youtube): self
    {
        $this->youtube = $youtube;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getBanner(): ?string
    {
        return $this->banner;
    }

    /**
     * @param  string|null  $banner
     *
     * @return $this
     */
    public function setBanner(?string $banner): self
    {
        $this->banner = $banner;

        return $this;
    }

}
