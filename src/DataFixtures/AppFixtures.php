<?php

namespace App\DataFixtures;

use App\Entity\User;
use App\Entity\Video;
use App\Entity\Historique;
use App\Entity\Rapport;
use App\Entity\Commentaire;
use App\Entity\Note;
use App\Entity\Abonnement;
use App\Entity\Favoris;
use App\Entity\Challenge;
use App\Entity\SubscriptionHistory;
use App\Entity\Programme;
use App\Enum\UserAccountStatus;
use App\Enum\VideoLevel;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // Création d'abonnements fictifs
        $abonnement1 = new Abonnement();
        $abonnement1->setTitle('Abonnement Basique');
        $abonnement1->setPrice(9.99);
        $abonnement1->setDuration(30);
        $abonnement1->setDescription('Accès à des vidéos de base pendant un mois');
        $manager->persist($abonnement1);
        $this->addReference('abonnement_1', $abonnement1); // On ajoute la référence pour utiliser plus tard

        $abonnement2 = new Abonnement();
        $abonnement2->setTitle('Abonnement Premium');
        $abonnement2->setPrice(19.99);
        $abonnement2->setDuration(30);
        $abonnement2->setDescription('Accès complet à tous les contenus vidéo pendant un mois');
        $manager->persist($abonnement2);
        $this->addReference('abonnement_2', $abonnement2); // On ajoute une autre référence

        $abonnement3 = new Abonnement();
        $abonnement3->setTitle('Abonnement Annuel');
        $abonnement3->setPrice(99.99);
        $abonnement3->setDuration(365);
        $abonnement3->setDescription('Accès complet pendant une année');
        $manager->persist($abonnement3);
        $this->addReference('abonnement_3', $abonnement3); // Une autre référence

        // Create a User
        $user = new User();
        $user->setFistName('John')
             ->setLastName('Doe')
             ->setBirthDate(new \DateTime('1990-01-01'))
             ->setSex('Male')
             ->setRole('Admin')
             ->setStatus(UserAccountStatus::ACTIVE)  // Ensure UserAccountStatus is correctly imported
             ->setCreationDate(new \DateTime())
             ->setUsername('johndoe')
             ->setEmail('john.doe@example.com')
             ->setPassword('printemps')
             ->setAbonnement($abonnement2);

        // Création de vidéos fictives
        for ($i = 1; $i <= 10; $i++) {
            $video = new Video();
            $video->setTitle('Video ' . $i);
            $video->setDescription('Description for video ' . $i);
            $video->setTheme('Theme ' . $i);
            $video->setFichierVideo('video' . $i . '.mp4');
            $video->setNoteGlobal(rand(1, 5));
            $video->setStatus('published');
            $video->setLevel(VideoLevel::DEBUTANT); // Utilisation de l'enum VideoLevel
            $video->setView(rand(0, 100));

            // Ajout de l'utilisateur à la vidéo
            $video->addUser($user);

            // Persist de la vidéo
            $manager->persist($video);
        }

        $video1 = new Video();
        $video1->setTitle('Video ' . $i);
        $video1->setDescription('Description for video ' . $i);
        $video1->setTheme('Theme ' . $i);
        $video1->setFichierVideo('video' . $i . '.mp4');
        $video1->setNoteGlobal(rand(1, 5));
        $video1->setStatus('published');
        $video1->setLevel(VideoLevel::DEBUTANT); // Utilisation de l'enum VideoLevel
        $video1->setView(rand(0, 100));
        $video1->addUser($user);
        $manager->persist($video1);

        // Création de défis fictifs
        for ($i = 1; $i <= 5; $i++) {
            $challenge = new Challenge();
            $challenge->setName('Challenge ' . $i);
            $challenge->setGoal('Atteindre un objectif pour le défi ' . $i);
            $challenge->setStartDate(new \DateTime('2024-01-01'));
            $challenge->setEndDate(new \DateTime('2024-01-31'));
            $challenge->setUserId($user); // Lier chaque défi à l'utilisateur créé

            // Persist du défi
            $manager->persist($challenge);
        }

        // Création d'un historique fictif
        $historique = new Historique();
        $historique->setDate(new \DateTime('2024-12-01'));
        $historique->setUser($user); // Lier l'historique à l'utilisateur créé

        // Association de vidéos à l'historique
        foreach ($video as $videos) {
            $historique->addVideo($videos); // Lier les vidéos à l'historique
        }

        // Persist de l'historique
        $manager->persist($historique);

        // Création de rapports fictifs
        foreach ($video as $videos) {
            $rapport = new Rapport();
            $rapport->setMotif('Motif de rapport pour ' . $videos->getTitle());
            $rapport->setDate(new \DateTime('2024-12-20 12:00:00'));
            $rapport->setUser($user); // Lier le rapport à l'utilisateur créé
            $rapport->setVideo($videos); // Lier le rapport à une vidéo

            $manager->persist($rapport);
        }

        // Création de commentaires fictifs
        foreach ($video as $videos) {
            $commentaire = new Commentaire();
            $commentaire->setContenu('Commentaire pour la vidéo ' . $videos->getTitle());
            $commentaire->setDate(new \DateTime('2024-12-01 12:00:00'));
            $commentaire->setUser($user); // Lier le commentaire à l'utilisateur créé
            $commentaire->setVideo($videos); // Lier le commentaire à une vidéo

            $manager->persist($commentaire);
        }
        $commentaire1 = new Commentaire();
        $commentaire1->setContenu('Commentaire pour la vidéo ' . $video->getTitle());
        $commentaire1->setDate(new \DateTime('2024-12-01 12:00:00'));
        $commentaire1->setUser($user); // Lier le commentaire à l'utilisateur créé
        $commentaire1->setVideo($video); // Lier le commentaire à une vidéo

        $manager->persist($commentaire1);

        // Création de notes fictives
        foreach ($video as $videos) {
            for ($j = 1; $j <= 2; $j++) {
                $note = new Note();
                $note->setValeur(rand(1, 5)); // Note aléatoire entre 1 et 5
                $note->setDate(new \DateTime('2024-12-01 12:00:00'));
                $note->setUser($user); // Lier la note à l'utilisateur créé
                $note->setVideo($videos); // Lier la note à une vidéo

                $manager->persist($note);
            }
        }

        $note1 = new Note();
        $note1->setValeur(rand(1, 5)); // Note aléatoire entre 1 et 5
        $note1->setDate(new \DateTime('2024-12-01 12:00:00'));
        $note1->setUser($user); // Lier la note à l'utilisateur créé
        $note1->setVideo($video); // Lier la note à une vidéo

        $manager->persist($note1);

        // Création de l'historique de vidéos vues fictif
        $history = new Historique();

        foreach ($video as $videos) {
            $history->addVideo($videos); // Associer chaque vidéo vue à l'historique
        }

        $manager->persist($history);

        // Création de programmes avec différents niveaux
        $programme1 = new Programme();
        $programme1->setTitle('Programme de Base');
        $programme1->setDescription('Ce programme est destiné aux débutants.');
        $programme1->setLevel(VideoLevel::INTERMEDIARE); // Niveau de vidéo "BASIC"
        
        // Association de vidéos avec ce programme
        foreach ($video as $videos) {
            $programme1->addVideoId($videos);
        }

        $manager->persist($programme1);

        $programme2 = new Programme();
        $programme2->setTitle('Programme Avancé');
        $programme2->setDescription('Programme pour les utilisateurs avancés.');
        $programme2->setLevel(VideoLevel::DEBUTANT); // Niveau de vidéo "ADVANCED"
        
        // Association de vidéos avec ce programme
        foreach ($video as $videos) {
            $programme2->addVideoId($videos);
        }

        $manager->persist($programme2);

        // Créer des historiques d'abonnement fictifs
        $subscriptionHistory1 = new SubscriptionHistory();
        $subscriptionHistory1->setUserId($user);
        $subscriptionHistory1->setStartDate(new \DateTime('2024-01-01 12:00:00'));
        $subscriptionHistory1->setEndDate(new \DateTime('2024-06-01 12:00:00'));
        $subscriptionHistory1->addSubscriptionId($abonnement1); // Lier un abonnement
        $manager->persist($subscriptionHistory1);

        // Créer des favoris fictifs
        $favoris = new Favoris();
        $favoris->setUserId($user);  // Associer à l'utilisateur 1
        $favoris->addVideoId($video1);  // Ajouter la vidéo 1 aux favoris
        $favoris->setAddedAt(new \DateTime('2024-12-20 12:00:00'));
        $manager->persist($favoris);

        // Création du rapport
        $rapport = new Rapport();
        $rapport->setMotif('Violation des règles')
                ->setDate(new \DateTime('2024-12-20 12:00:00'))
                ->setUser($user) // Associer l'utilisateur au rapport
                ->setVideo($video); 
        // Persister le rapport
        $manager->persist($rapport);

        // Add collections
        $user->addVideoEnregistrer($video);
        $user->addHistorique($history);
        $user->addRapport($rapport);
        $user->addCommentaire($commentaire1);
        $user->addNote($note1);
        $user->addSubscriptionHistory($subscriptionHistory1);
        $user->addChallenge($challenge);
        $user->addFavori($favoris);
        $manager->persist($user);

        // Enregistrement dans la base de données
        $manager->flush();
    }
}