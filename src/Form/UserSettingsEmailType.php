<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Email;

class UserSettingsEmailType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('oldEmail',EmailType::class, ['label' =>'Adresse email actuelle',])
            ->add('newEmail',EmailType::class, ['label' =>'Nouvelle adresse email', 'attr' => ['value' => ""]])
            ->add('password',PasswordType::class, ['label' =>'Mot de passe', 'attr' => ['value' => ""]])
            ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
