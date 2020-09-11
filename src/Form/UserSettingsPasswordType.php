<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserSettingsPasswordType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('oldPass',PasswordType::class,['label' => 'Mot de passe actuel', 'attr' => ['value' => '']])
            ->add('newPass',PasswordType::class,['label' => 'Nouveau mot de passe', 'attr' => ['value' => '']])
            ->add('confirmPass',PasswordType::class,['label' => 'Confirmation du mot de passe', 'attr' => ['value' => '']])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
