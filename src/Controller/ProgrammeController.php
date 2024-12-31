<?php

namespace App\Controller;

use App\Repository\ProgrammeRepository;
use App\Repository\VideoRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ProgrammeController extends AbstractController
{
    #[Route('/programme', name: 'app_programme')]
    public function index(ProgrammeRepository $programmeRepository,VideoRepository $videoRepository): Response
    {
        $programmes = $programmeRepository->findAll();
        $videos = $videoRepository->findAll();

        return $this->render('programme/index.html.twig', [
            'controller_name' => 'ProgrammeController',
            'programmes' => $programmes,
            'videos' => $videos,
        ]);
    }
}
