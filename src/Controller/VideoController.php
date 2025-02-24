<?php

namespace App\Controller;

use App\Entity\Video;
use App\Entity\User;
use App\Form\VideoType;
use App\Repository\VideoRepository;
use App\Enum\ProgrammeTheme;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

#[Route('/video')]
final class VideoController extends AbstractController
{
    #[Route(name: 'app_video_index', methods: ['GET'])]
    public function index(VideoRepository $videoRepository): Response
    {
        $allVideos = $videoRepository->findAll();

        $recommendedVideos = array_filter($allVideos, function($video) {
            return $video->isRecommended(); // ou $video->getRecommended() selon votre getter
        });

        $themes = ProgrammeTheme::cases();
        
        return $this->render('video/index.html.twig', [
            'videos' => $allVideos,
            'topVideos' => $recommendedVideos,
            'themes' => $themes
        ]);
    }

    #[Route('/admin/new', name: 'app_video_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager,SluggerInterface $slugger): Response
    {
        $video = new Video();
        $form = $this->createForm(VideoType::class, $video);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $fichierVideo = $form->get('fichierVideo')->getData();

            if ($fichierVideo) {
                $originalFilename = pathinfo($fichierVideo->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$fichierVideo->guessExtension();

                try {
                    $fichierVideo->move(
                        $this->getParameter('video_upload_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {

                }

                $video->setFichierVideo($newFilename);
            }

            $entityManager->persist($video);
            $entityManager->flush();

            return $this->redirectToRoute('app_video_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('video/new.html.twig', [
            'video' => $video,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_video_show', methods: ['GET'])]
    public function show(Video $video, VideoRepository $videoRepository): Response
    {

        // Récupérer les vidéos ayant le même thème que la vidéo actuelle
        $videosWithSameTheme = $videoRepository->findVideosWithSameTheme(
            $video->getTheme(),
            $video->getId()
        );

        return $this->render('video/show.html.twig', [
            'videoSame' => $videosWithSameTheme,
            'video' => $video,
        ]);
    }

    #[Route('/admin/{id}/edit', name: 'app_video_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Video $video, EntityManagerInterface $entityManager,SluggerInterface $slugger): Response
    {
        $form = $this->createForm(VideoType::class, $video);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $fichierVideo = $form->get('fichierVideo')->getData();

            if ($fichierVideo) {
                $originalFilename = pathinfo($fichierVideo->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$fichierVideo->guessExtension();

                try {
                    $fichierVideo->move(
                        $this->getParameter('video_upload_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {

                }

                $video->setFichierVideo($newFilename);
            }

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

                $video->setImage($newImageFilename);
            }

            $entityManager->flush();

            return $this->redirectToRoute('app_video_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('video/edit.html.twig', [
            'video' => $video,
            'form' => $form,
        ]);
    }

    #[Route('/admin/{id}', name: 'app_video_delete', methods: ['POST'])]
    public function delete(Request $request, Video $video, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$video->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($video);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_video_index', [], Response::HTTP_SEE_OTHER);
    }
}
