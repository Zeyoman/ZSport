<?php

namespace App\Controller;

use App\Entity\Programme;
use App\Form\ProgrammeType;
use App\Repository\ProgrammeRepository;
use App\Repository\VideoRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/programme')]
final class ProgrammeController extends AbstractController
{
    #[Route(name: 'app_programme_index', methods: ['GET'])]
    public function index(ProgrammeRepository $programmeRepository, VideoRepository $videoRepository): Response
    {

        $programmes = $programmeRepository->findAll();
        $videos = $videoRepository->findAll();

        return $this->render('programme/index.html.twig', [
            'controller_name' => 'ProgrammeController',
            'programmes' => $programmes,
            'videos' => $videos,
        ]);
    }

    #[Route('/admin/new', name: 'app_programme_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, SluggerInterface $slugger): Response
    {
        $programme = new Programme();
        $form = $this->createForm(ProgrammeType::class, $programme);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $fichierImage = $form->get('image')->getData();

            if ($fichierImage) {
                $originalImageFilename = pathinfo($fichierImage->getClientOriginalName(), PATHINFO_FILENAME);
                $safeImageFilename = $slugger->slug($originalImageFilename);
                $newImageFilename = $safeImageFilename.'-'.uniqid().'.'.$fichierImage->guessExtension();

                try {
                    $fichierImage->move(
                        $this->getParameter('image_upload_directory'),
                        $newImageFilename
                    );
                } catch (FileException $e) {

                }

                $programme->setImage($newImageFilename);
            }
            $entityManager->persist($programme);
            $entityManager->flush();

            return $this->redirectToRoute('app_programme_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('programme/new.html.twig', [
            'programme' => $programme,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_programme_show', methods: ['GET'])]
    public function show(Programme $programme): Response
    {
        return $this->render('programme/show.html.twig', [
            'programme' => $programme,
        ]);
    }

    #[Route('/admin/{id}/edit', name: 'app_programme_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Programme $programme, EntityManagerInterface $entityManager, SluggerInterface $slugger): Response
    {
        $form = $this->createForm(ProgrammeType::class, $programme);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $fichierImage = $form->get('image')->getData();

            if ($fichierImage) {
                $originalImageFilename = pathinfo($fichierImage->getClientOriginalName(), PATHINFO_FILENAME);
                $safeImageFilename = $slugger->slug($originalImageFilename);
                $newImageFilename = $safeImageFilename.'-'.uniqid().'.'.$fichierImage->guessExtension();

                try {
                    $fichierImage->move(
                        $this->getParameter('image_upload_directory'),
                        $newImageFilename
                    );
                } catch (FileException $e) {

                }

                $programme->setImage($newImageFilename);
            }
            $entityManager->persist($programme);
            $entityManager->flush();

            return $this->redirectToRoute('app_programme_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('programme/edit.html.twig', [
            'programme' => $programme,
            'form' => $form,
        ]);
    }

    #[Route('/admin/{id}', name: 'app_programme_delete', methods: ['POST'])]
    public function delete(Request $request, Programme $programme, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$programme->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($programme);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_programme_index', [], Response::HTTP_SEE_OTHER);
    }
}
