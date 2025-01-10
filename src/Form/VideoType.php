<?php

namespace App\Form;

use App\Entity\Favoris;
use App\Entity\Historique;
use App\Entity\Programme;
use App\Entity\User;
use App\Entity\Video;
use App\Enum\VideoLevel;
use CodeIgniter\Files\File;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\EnumType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class VideoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title')
            ->add('description')
            ->add('theme')
            ->add('image', FileType::class, [
                'label' => 'Image de la vidéo',
                'mapped' => false,
                'required' => false,
            ])
            ->add('fichierVideo', FileType::class, [
                'label' => 'Fichier vidéo',
                'mapped' => false,
                'required' => false,
            ])
            ->add('noteGlobal')
            ->add('status')
            ->add('level', EnumType::class, [
                'class' => VideoLevel::class,
                'choice_label' => fn($choice) => ucfirst($choice->name), // Affiche les noms en majuscule initiale
                'placeholder' => 'Sélectionnez un niveau',
                'label' => 'Niveau de la vidéo',
            ])
            ->add('view')
            ->add('historique', EntityType::class, [
                'class' => Historique::class,
                'choice_label' => 'id',
            ])
            ->add('favoris', EntityType::class, [
                'class' => Favoris::class,
                'choice_label' => 'id',
                'multiple' => true,
            ])
            ->add('programmes', EntityType::class, [
                'class' => Programme::class,
                'choice_label' => 'id',
                'multiple' => true,
            ])
            ->add('users', EntityType::class, [
                'class' => User::class,
                'choice_label' => 'id',
                'multiple' => true,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Video::class,
        ]);
    }
}
