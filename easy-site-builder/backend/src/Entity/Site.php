<?php

namespace App\Entity;

use App\Repository\SiteRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=SiteRepository::class)
 * @ORM\Table(name="sites")
 */
class Site
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
    private $name;

    /**
     * @ORM\Column(type="string", length=255, unique=true)
     */
    private $slug;

    /**
     * @ORM\Column(type="integer")
     */
    private $owner_user_id;

    /**
     * @ORM\Column(type="datetime")
     */
    private $created_at;

    /**
     * @ORM\OneToMany(targetEntity=Page::class, mappedBy="site", orphanRemoval=true)
     */
    private $pages;

    /**
     * @ORM\OneToOne(targetEntity=SiteSettings::class, mappedBy="site", cascade={"persist", "remove"})
     */
    private $settings;

    public function __construct()
    {
        $this->pages = new ArrayCollection();
        $this->created_at = new \DateTime();
    }

    // Getters and Setters

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;
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

    public function getOwnerUserId(): ?int
    {
        return $this->owner_user_id;
    }

    public function setOwnerUserId(int $owner_user_id): self
    {
        $this->owner_user_id = $owner_user_id;
        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeInterface $created_at): self
    {
        $this->created_at = $created_at;
        return $this;
    }

    public function getPages(): Collection
    {
        return $this->pages;
    }

    public function addPage(Page $page): self
    {
        if (!$this->pages->contains($page)) {
            $this->pages[] = $page;
            $page->setSite($this);
        }

        return $this;
    }

    public function removePage(Page $page): self
    {
        if ($this->pages->removeElement($page)) {
            if ($page->getSite() === $this) {
                $page->setSite(null);
            }
        }

        return $this;
    }

    public function getSettings(): ?SiteSettings
    {
        return $this->settings;
    }

    public function setSettings(SiteSettings $settings): self
    {
        $this->settings = $settings;
        $settings->setSite($this);

        return $this;
    }
}