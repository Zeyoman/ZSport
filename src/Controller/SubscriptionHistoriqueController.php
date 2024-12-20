<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class SubscriptionHistoriqueController extends AbstractController
{
    #[Route('/subscription/historique', name: 'app_subscription_historique')]
    public function index(): Response
    {
        return $this->render('subscription_historique/index.html.twig', [
            'controller_name' => 'SubscriptionHistoriqueController',
        ]);
    }
}
