<?php

namespace App\Controller;

use App\Entity\Programme;
use App\Repository\ProgrammeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ProgrammeController extends AbstractController
{
    #[Route('/programme', name: 'app_programme')]
    public function index(ProgrammeRepository $programmeRepository): Response
    {
        $programmes = $programmeRepository->findAll();

        return $this->render('programme/index.html.twig', [
            'controller_name' => 'ProgrammeController',
            'programmes' => $programmes,
        ]);
    }
}
