<?php

namespace App\Form;

use App\Entity\Category;
use App\Entity\Course;
use App\Entity\SubCategory;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CourseType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title',TextType::class, ['label' => 'Titre du cours', 'attr' => ['placeholder' => 'Donnez un titre à votre cours'] ] )
            ->add('description',TextareaType::class, ['label' => 'Résumé du cours', 'attr' => ['placeholder' => 'Donnez un résumé ou une décription à votre cours'] ])
            ->add('level',ChoiceType::class,['choices' => [
                'Débutant' => 'starter',
                'Intermediare' => 'middle',
                'Elevé' => 'high',
                'Expert' => 'expert',
            ], 'label' => 'Niveau' ])
            ->add('language',ChoiceType::class,['choices' => [
                'Français' => 'Fr',
                'Anglais' => 'Ang',
                'Espagnol' => 'ES',
            ], 'label' => 'Langue' ])
            ->add('category',EntityType::class, [
                'class' => Category::class,
                'choice_label' => 'title',
                'choice_value' => 'id',
                'label' => 'Categorie',
            ])
            ->add('subCategory',EntityType::class,[
                'class' => SubCategory::class,
                'choice_label' => 'title',
                'choice_value' => 'id', 
                'label' => 'Sous Categorie' ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Course::class,
        ]);
    }
}
