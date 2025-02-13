<?php

namespace App\Controller;

use App\Repository\AbonnementRepository;
use App\Repository\VideoRepository;
use App\Repository\ProgrammeRepository;
use App\Enum\ProgrammeTheme;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'Homepage')]
    public function index(AbonnementRepository $abonnementRepository, VideoRepository $videoRepository, ProgrammeRepository $programmeRepository): Response
    {
        /** @var User|null $user */
        $user = $this->getUser();

        $abonnementUser = $user ? $user->getAbonnement() : '';

        $abonnements = $abonnementRepository->findAll();

        $videos = $videoRepository->findAll();

        $programmes = $programmeRepository->findAll();

        $themes = ProgrammeTheme::cases();

        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
            'abonnements' => $abonnements,
            'abonnementUser' => $abonnementUser,
            'videos' => $videos,
            'programmes' => $programmes,
            'themes' => $themes
        ]);
    }
}
