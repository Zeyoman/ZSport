<?php

namespace App\Controller;

use App\Repository\AbonnementRepository;
use App\Repository\VideoRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'Homepage')]
    public function index(AbonnementRepository $abonnementRepository, VideoRepository $videoRepository): Response
    {

        /** @var User|null $user */
        $user = $this->getUser();

        $abonnementUser = $user ? $user->getAbonnement() : '';

        $abonnements = $abonnementRepository->findAll();

        $videos = $videoRepository->findAll();

        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
            'abonnements' => $abonnements,
            'abonnementUser' => $abonnementUser,
            'videos' => $videos
        ]);
    }
}
