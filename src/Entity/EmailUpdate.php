<?php

namespace App\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Security\Core\Validator\Constraints as SecurityAssert;

class EmailUpdate
{
    /**
     * @Assert\NotBlank( message="Entrez votre adresse email actuelle" )
     */
    private $oldEmail;

    /**
     * @Assert\Email(
     *     message = "Entrez une adresse email valide"
     * )
     */
    private $newEmail;

    /**
     * @SecurityAssert\UserPassword(
     *     message = "mot de passe incorrect"
     * )
     */
    private $password;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getOldEmail(): ?string
    {
        return $this->oldEmail;
    }

    public function setOldEmail(string $oldEmail): self
    {
        $this->oldEmail = $oldEmail;

        return $this;
    }

    public function getNewEmail(): ?string
    {
        return $this->newEmail;
    }

    public function setNewEmail(string $newEmail): self
    {
        $this->newEmail = $newEmail;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }
}
