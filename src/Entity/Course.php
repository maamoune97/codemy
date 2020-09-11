<?php

namespace App\Entity;

use Cocur\Slugify\Slugify;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CourseRepository")
 * @ORM\HasLifecycleCallbacks
 * @UniqueEntity("title", message="Ce titre est déjà reserver par un autre cours")
 */
class Course
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotNull(message="Vous devez spécifier un titre pour votre cours")
     */
    private $title;

    /**
     * @Assert\NotNull
     * @ORM\Column(type="text")
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=15)
     */
    private $level;

    /**
     * @ORM\Column(type="string", length=4)
     */
    private $language;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime")
     */
    private $updatedAt;

    /**
     * @ORM\Column(type="boolean")
     */
    private $online;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="courses")
     * @ORM\JoinColumn(nullable=false)
     */
    private $formator;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Part", mappedBy="course", orphanRemoval=true)
     */
    private $parts;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\SubCategory", inversedBy="courses")
     * @ORM\JoinColumn(nullable=false)
     */
    private $subCategory;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $slug;

    /**
     * @ORM\OneToMany(targetEntity=Prerequisite::class, mappedBy="course", orphanRemoval=true)
     */
    private $prerequisites;

    /**
     * @ORM\PrePersist
     *
     * @return void
     */
    public function initializeSlug()
    {
        if (empty($this->slug)) {
            $this->slug = (new Slugify())->slugify($this->title) ;
        }
    }

    /**
     * @ORM\PreUpdate
     *
     * @return void
     */
    public function updateSlug()
    {
        $this->slug = (new Slugify())->slugify($this->title) ;
    }

    public function __construct()
    {
        $this->parts = new ArrayCollection();
        $this->prerequisites = new ArrayCollection();
        $this->category = new Category();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

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

    public function getLevel(): ?string
    {
        return $this->level;
    }

    public function setLevel(string $level): self
    {
        $this->level = $level;

        return $this;
    }

    public function getLanguage(): ?string
    {
        return $this->language;
    }

    public function setLanguage(string $language): self
    {
        $this->language = $language;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function getOnline(): ?bool
    {
        return $this->online;
    }

    public function setOnline(bool $online): self
    {
        $this->online = $online;

        return $this;
    }

    public function getFormator(): ?User
    {
        return $this->formator;
    }

    public function setFormator(?User $formator): self
    {
        $this->formator = $formator;

        return $this;
    }

    /**
     * @return Collection|Part[]
     */
    public function getParts(): Collection
    {
        return $this->parts;
    }

    public function addPart(Part $part): self
    {
        if (!$this->parts->contains($part)) {
            $this->parts[] = $part;
            $part->setCourse($this);
        }

        return $this;
    }

    public function removePart(Part $part): self
    {
        if ($this->parts->contains($part)) {
            $this->parts->removeElement($part);
            // set the owning side to null (unless already changed)
            if ($part->getCourse() === $this) {
                $part->setCourse(null);
            }
        }

        return $this;
    }

    public function getSubCategory(): ?SubCategory
    {
        return $this->subCategory;
    }

    public function setSubCategory(?SubCategory $subCategory): self
    {
        $this->subCategory = $subCategory;

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

    /**
     * @return Collection|Prerequisite[]
     */
    public function getPrerequisites(): Collection
    {
        return $this->prerequisites;
    }

    public function addPrerequisite(Prerequisite $prerequisite): self
    {
        if (!$this->prerequisites->contains($prerequisite)) {
            $this->prerequisites[] = $prerequisite;
            $prerequisite->setCourse($this);
        }

        return $this;
    }

    public function removePrerequisite(Prerequisite $prerequisite): self
    {
        if ($this->prerequisites->contains($prerequisite)) {
            $this->prerequisites->removeElement($prerequisite);
            // set the owning side to null (unless already changed)
            if ($prerequisite->getCourse() === $this) {
                $prerequisite->setCourse(null);
            }
        }

        return $this;
    }

    private $category;

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): self
    {
        $this->category = $category;

        return $this;
    }
}
