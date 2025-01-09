<?php

namespace App\Form;

use App\Entity\Abonnement;
use App\Entity\User;
use App\Entity\Video;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('username')
            ->add('roles')
            ->add('password')
            ->add('firstName')
            ->add('lastName')
            ->add('birthDate', null, [
                'widget' => 'single_text',
            ])
            ->add('sex')
            ->add('status')
            ->add('creationDate', null, [
                'widget' => 'single_text',
            ])
            ->add('email')
            ->add('isVerified')
            ->add('abonnement', EntityType::class, [
                'class' => Abonnement::class,
                'choice_label' => 'id',
            ])
            ->add('videoEnregistrer', EntityType::class, [
                'class' => Video::class,
                'choice_label' => 'id',
                'multiple' => true,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
