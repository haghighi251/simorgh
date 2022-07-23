<?php

namespace App\Entity;

use App\Repository\SettingsRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=SettingsRepository::class)
 */
class Settings
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $site_title;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $site_description;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $admin_email;

    /**
     * @ORM\Column(type="boolean")
     */
    private $membership;

    /**
     * @ORM\Column(type="integer")
     */
    private $content_count_limitation;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $support_email;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $shop_address_one;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $shop_address_two;

    /**
     * @ORM\Column(type="string", length=30)
     */
    private $support_number_one;

    /**
     * @ORM\Column(type="string", length=30, nullable=true)
     */
    private $support_number_two;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $facebook;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $instagram;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $twitter;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $linkedin;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSiteTitle(): ?string
    {
        return $this->site_title;
    }

    public function setSiteTitle(string $site_title): self
    {
        $this->site_title = $site_title;

        return $this;
    }

    public function getSiteDescription(): ?string
    {
        return $this->site_description;
    }

    public function setSiteDescription(string $site_description): self
    {
        $this->site_description = $site_description;

        return $this;
    }

    public function getAdminEmail(): ?string
    {
        return $this->admin_email;
    }

    public function setAdminEmail(string $admin_email): self
    {
        $this->admin_email = $admin_email;

        return $this;
    }

    public function getMembership(): ?bool
    {
        return $this->membership;
    }

    public function setMembership(bool $membership): self
    {
        $this->membership = $membership;

        return $this;
    }

    public function getContentCountLimitation(): ?int
    {
        return $this->content_count_limitation;
    }

    public function setContentCountLimitation(int $content_count_limitation): self
    {
        $this->content_count_limitation = $content_count_limitation;

        return $this;
    }

    public function getSupportEmail(): ?string
    {
        return $this->support_email;
    }

    public function setSupportEmail(string $support_email): self
    {
        $this->support_email = $support_email;

        return $this;
    }

    public function getShopAddressOne(): ?string
    {
        return $this->shop_address_one;
    }

    public function setShopAddressOne(string $shop_address_one): self
    {
        $this->shop_address_one = $shop_address_one;

        return $this;
    }

    public function getShopAddressTwo(): ?string
    {
        return $this->shop_address_two;
    }

    public function setShopAddressTwo(?string $shop_address_two): self
    {
        $this->shop_address_two = $shop_address_two;

        return $this;
    }

    public function getSupportNumberOne(): ?string
    {
        return $this->support_number_one;
    }

    public function setSupportNumberOne(string $support_number_one): self
    {
        $this->support_number_one = $support_number_one;

        return $this;
    }

    public function getSupportNumberTwo(): ?string
    {
        return $this->support_number_two;
    }

    public function setSupportNumberTwo(?string $support_number_two): self
    {
        $this->support_number_two = $support_number_two;

        return $this;
    }

    public function getFacebook(): ?string
    {
        return $this->facebook;
    }

    public function setFacebook(?string $facebook): self
    {
        $this->facebook = $facebook;

        return $this;
    }

    public function getInstagram(): ?string
    {
        return $this->instagram;
    }

    public function setInstagram(?string $instagram): self
    {
        $this->instagram = $instagram;

        return $this;
    }

    public function getTwitter(): ?string
    {
        return $this->twitter;
    }

    public function setTwitter(?string $twitter): self
    {
        $this->twitter = $twitter;

        return $this;
    }

    public function getLinkedin(): ?string
    {
        return $this->linkedin;
    }

    public function setLinkedin(?string $linkedin): self
    {
        $this->linkedin = $linkedin;

        return $this;
    }
}
