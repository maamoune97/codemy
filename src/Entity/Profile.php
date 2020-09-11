<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ProfileRepository")
 */
class Profile
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $avatar;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $dateOfBirth;

    /**
     * @ORM\Column(type="string", length=1, nullable=true)
     */
    private $gender;

    /**
     * @ORM\Column(type="string", length=40, nullable=true)
     */

    private $job;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\User", inversedBy="profile", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity=WorldCountries::class, inversedBy="profiles")
     */
    private $location;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAvatar(): ?string
    {
        return $this->avatar;
    }

    public function setAvatar(?string $avatar): self
    {
        $this->avatar = $avatar;

        return $this;
    }

    public function getDateOfBirth(): ?\DateTimeInterface
    {
        return $this->dateOfBirth;
    }

    public function setDateOfBirth(?\DateTimeInterface $dateOfBirth): self
    {
        $this->dateOfBirth = $dateOfBirth;

        return $this;
    }

    public function getGender(): ?string
    {
        return $this->gender;
    }

    public function setGender(?string $gender): self
    {
        $this->gender = $gender;

        return $this;
    }

    public function getJob(): ?string
    {
        return $this->job;
    }

    public function setJob(?string $job): self
    {
        $this->job = $job;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getLocation(): ?WorldCountries
    {
        return $this->location;
    }

    public function setLocation(?WorldCountries $location): self
    {
        $this->location = $location;

        return $this;
    }
    
    private $genderNameFr = ['M' => 'Masculin', 'F' => 'Feminin', 'A' => 'Autre'];

    /**
     * @ORM\Column(type="boolean")
     */
    private $shareProfile;

    public function getGenderNameFr(): ?string
    {
        if ($this->gender)
        {
            return $this->genderNameFr[$this->gender];
        }else
        {
            return $this->gender;
        }
    }

    public function getShareProfile(): ?bool
    {
        return $this->shareProfile;
    }

    public function setShareProfile(bool $shareProfile): self
    {
        $this->shareProfile = $shareProfile;

        return $this;
    }
}
