<?php

namespace App\DataFixtures;

use App\Entity\User;
use App\Entity\Video;
use App\Entity\Historique;
use App\Entity\Rapport;
use App\Entity\Commentaire;
use App\Entity\Note;
use App\Entity\Abonnement;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // Création des abonnements
        $abonnement1 = new Abonnement();
        $abonnement1->setTitle("Basique")
                    ->setPrice(9.99)
                    ->setDuration(30); // 1 mois
        $manager->persist($abonnement1);

        $abonnement2 = new Abonnement();
        $abonnement2->setTitle("Premium")
                    ->setPrice(19.99)
                    ->setDuration(365); // 1 an
        $manager->persist($abonnement2);

        // Création des utilisateurs
        $utilisateur1 = new User();
        $utilisateur1->setFistName("Dupont")
                     ->setLastName("Jean")
                     ->setBirthDate(new \DateTime('1990-05-20'))
                     ->setSex("Homme")
                     ->setRole("ROLE_USER")
                     ->setAbonnement($abonnement1);
        $manager->persist($utilisateur1);

        $utilisateur2 = new User();
        $utilisateur2->setFistName("Martin")
                     ->setLastName("Marie")
                     ->setBirthDate(new \DateTime('1995-10-10'))
                     ->setSex("Femme")
                     ->setRole("ROLE_ADMIN")
                     ->setAbonnement($abonnement2);
        $manager->persist($utilisateur2);

        // Création des vidéos
        $video1 = new Video();
        $video1->setTitle("Vidéo 1")
               ->setDescription("Une description pour la vidéo 1")
               ->setTheme("haut du corps")
               ->setImage("image1.jpg")
               ->setFichierVideo("video1.mp4")
               ->setNoteGlobal(4.5)
               ->setStatus("test");
        $manager->persist($video1);

        $video2 = new Video();
        $video2->setTitle("Vidéo 2")
               ->setDescription("Une description pour la vidéo 2")
               ->setTheme("Bas du corps")
               ->setImage("image2.jpg")
               ->setFichierVideo("video2.mp4")
               ->setNoteGlobal(4.0)
               ->setStatus("test");
        $manager->persist($video2);

        // Création des historiques
        $historique = new Historique();
        $historique->setUser($utilisateur1)
                   ->addVideo($video1)
                   ->setDate(new \DateTime('2024-01-01'));
        $manager->persist($historique);

        // Création des rapports
        $rapport = new Rapport();
        $rapport->setUser($utilisateur2)
                ->setVideo($video1)
                ->setMotif("Contenu inapproprié")
                ->setDate(new \DateTime('2024-02-01'));
        $manager->persist($rapport);

        // Création des commentaires
        $commentaire = new Commentaire();
        $commentaire->setUser($utilisateur1)
                    ->setVideo($video2)
                    ->setContenu("C'est une vidéo très efficace !")
                    ->setDate(new \DateTime('2024-03-01'));
        $manager->persist($commentaire);

        // Création des notes
        $note = new Note();
        $note->setUser($utilisateur2)
             ->setVideo($video1)
             ->setValeur(5);
        $manager->persist($note);

        // Enregistrement dans la base de données
        $manager->flush();
    }
}