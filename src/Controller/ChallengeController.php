<?php

namespace App\Controller;

use App\Entity\Challenge;
use App\Form\ChallengeType;
use App\Repository\ChallengeRepository;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Service\ChatGPTClient;

#[Route('/challenge')]
final class ChallengeController extends AbstractController
{
    #[Route(name: 'app_challenge_index', methods: ['GET', 'POST'])]
    public function index(Request $request, HttpClientInterface $client): Response
    {
        // Création du formulaire pour choisir la difficulté
        $form = $this->createFormBuilder()
            ->add('niveau', ChoiceType::class, [
                'choices'  => [
                    'Facile'        => 'facile',
                    'Intermédiaire' => 'intermédiaire',
                    'Difficile'     => 'difficile',
                ],
                'expanded' => true,
                'multiple' => false,
                'label'    => 'Choisissez la difficulté'
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Générer mes défis',
                'attr'  => ['class' => 'btn btn-primary']
            ])
            ->getForm();

        $form->handleRequest($request);
        $challenges = null;

        if ($form->isSubmitted() && $form->isValid()) {
            $data   = $form->getData();
            $niveau = $data['niveau'];

            // Construction du prompt
            $prompt = "donne moi des défis sportif a faire a la maison pour un niveau " . $niveau;

            // Préparation des messages pour OpenAI ChatCompletion
            $messages = [
                [ "role" => "system", "content" => "Tu es un expert en entraînement sportif à la maison." ],
                [ "role" => "user", "content" => $prompt ]
            ];

            // URL et clé de l'API OpenAI
            $apiUrl = 'https://api.openai.com/v1/chat/completions';
            $apiKey = $this->getParameter('openai_api_key');

            try {
                $response = $client->request('POST', $apiUrl, [
                    'headers' => [
                        'Authorization' => 'Bearer ' . $apiKey,
                        'Content-Type'  => 'application/json',
                    ],
                    'json' => [
                        'model'       => 'gpt-3.5-turbo',
                        'messages'    => $messages,
                        'temperature' => 0.7,
                    ],
                ]);

                $result = $response->toArray();

                if (isset($result['choices'][0]['message']['content'])) {
                    $challenges = $result['choices'][0]['message']['content'];
                } else {
                    $challenges = "Aucun défi généré. Essayez de nouveau.";
                }
            } catch (\Exception $e) {
                $challenges = "Erreur lors de la génération des défis : " . $e->getMessage();
            }
        }

        return $this->render('challenge/index.html.twig', [
            'form'      => $form->createView(),
            'challenges'=> $challenges,
        ]);
    }

    // #[Route(name: 'app_challenge_index', methods: ['GET'])]
    // public function index(ChallengeRepository $challengeRepository): Response
    // {
    //     $user = $this->getUser();

    //     var_dump($user->getRoles());
        
    //     return $this->render('challenge/index.html.twig', [
    //         'challenges' => $challengeRepository->findAll(),
    //     ]);
        
    // }

    #[Route('/admin/new', name: 'app_challenge_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $challenge = new Challenge();
        $form = $this->createForm(ChallengeType::class, $challenge);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($challenge);
            $entityManager->flush();

            return $this->redirectToRoute('app_challenge_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('challenge/new.html.twig', [
            'challenge' => $challenge,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_challenge_show', methods: ['GET'])]
    public function show(Challenge $challenge): Response
    {
        return $this->render('challenge/show.html.twig', [
            'challenge' => $challenge,
        ]);
    }

    #[Route('/admin/{id}/edit', name: 'app_challenge_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Challenge $challenge, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ChallengeType::class, $challenge);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_challenge_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('challenge/edit.html.twig', [
            'challenge' => $challenge,
            'form' => $form,
        ]);
    }

    #[Route('/admin/{id}', name: 'app_challenge_delete', methods: ['POST'])]
    public function delete(Request $request, Challenge $challenge, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$challenge->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($challenge);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_challenge_index', [], Response::HTTP_SEE_OTHER);
    }
}
