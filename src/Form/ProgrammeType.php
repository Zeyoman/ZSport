<?php

namespace App\Form;

use App\Entity\Programme;
use App\Entity\Video;
use App\Enum\VideoLevel;
use Symfony\Component\Form\Extension\Core\Type\EnumType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProgrammeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title')
            ->add('description')
            ->add('level', EnumType::class, [
                'class' => VideoLevel::class,
                'label' => 'Niveau',
                'placeholder' => 'Sélectionnez un niveau',
                'choice_label' => function (VideoLevel $level) {
                    return $level->value;
                },
            ])
            ->add('videoId', EntityType::class, [
                'class' => Video::class,
                'choice_label' => 'id',
                'multiple' => true,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Programme::class,
        ]);
    }
}
