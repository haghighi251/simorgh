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
}
