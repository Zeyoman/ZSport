<?php

namespace App\Controller;

use App\Repository\FavorisRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class FavorisController extends AbstractController
{
    #[Route('/favoris', name: 'app_favoris')]
    #[IsGranted('ROLE_USER')]
    public function index( FavorisRepository $favorisRepository): Response
    {
        $user = $this->getUser();

        $mesFavoris = $favorisRepository->findBy(['user' => $user]);

        return $this->render('favoris/index.html.twig', [
            'controller_name' => 'FavorisController',
            'UserFavoris' => $mesFavoris,
        ]);
    }
}
