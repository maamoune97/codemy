<?php

namespace App\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Security\Core\Validator\Constraints as SecurityAssert;

class PasswordUpdate
{
    /**
     * @SecurityAssert\UserPassword(
     *     message = "le mot de passe est incorrect"
     * )
     * @Assert\NotBlank(message="Entrez votre mot de passe")
     */
    private $oldPass;

    /**
     * @Assert\Length(
     * max = 255,
     * maxMessage = "le mot de passe doit contenir au maximum 255 charatères"
     * )
     *
     */
    private $newPass;

     /**
     * @Assert\NotBlank(message="Confirmez le nouveau mot de passe") 
     * @Assert\EqualTo(propertyPath="newPass", message="les mots de passe ne correspondent pas")
     */
    private $confirmPass;

    public function getOldPass(): ?string
    {
        return $this->oldPass;
    }

    public function setOldPass(string $oldPass): self
    {
        $this->oldPass = $oldPass;

        return $this;
    }

    public function getNewPass(): ?string
    {
        return $this->newPass;
    }

    public function setNewPass(string $newPass): self
    {
        $this->newPass = $newPass;

        return $this;
    }

    public function getConfirmPass(): ?string
    {
        return $this->confirmPass;
    }

    public function setConfirmPass(string $confirmPass): self
    {
        $this->confirmPass = $confirmPass;

        return $this;
    }
}
