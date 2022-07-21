<?php

namespace App\Controller;

use App\Entity\Media;
use App\Entity\Message;
use App\Entity\Trick;
use App\Entity\TrickGroup;
use App\Entity\User;
use App\Form\CommentaryFormType;
use App\Form\CreateTrickFormType;
use App\Form\ModifyTrickFormType;
use App\Repository\MessageRepository;
use App\Repository\TrickGroupRepository;
use App\Repository\UserRepository;
use App\Repository\TrickRepository;
use DateTimeImmutable;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping\Entity;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\UnicodeString;

class TricksController extends AbstractController
{
    #[Route('/', name: 'app_home_')]
    public function homepage(TrickRepository $trickRepository): Response
    {
        return $this->render('tricks/homepage.html.twig', [
            'title' => 'Snow Tricks', 'tricks' => $trickRepository->findBy(
                [],
                ['trickName' => 'asc']
            )
        ]);
    }
    #[Route('trick/{slug}', name: 'app_trick')]
    public function show(
        Trick $trick,
        TrickRepository $trickRepository,
        MessageRepository $messageRepository,
        Request $request,
        EntityManagerInterface $entityManager,
        UserRepository $userRepository
    ): Response {

        $user = $this->getUser();
        $messages = $messageRepository->findByIdTrick($trick);
        $form = $this->createForm(CommentaryFormType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() and $form->isValid()) {
            $newMessage = new Message;
            $newMessage->setContent($form->get('comment')->getData());
            $newMessage->setIdTrick($trick);
            $newMessage->setDate(new DateTimeImmutable());
            $newMessage->setAuthor($user);
            $entityManager->persist($newMessage);
            $entityManager->flush();
            $this->addFlash('success', 'Commentaire publié');
            $currentSlug = $request->get('slug');
            return $this->redirectToRoute('app_trick', ['slug' => $currentSlug]);
        }

        return $this->render(
            'tricks/tricks.html.twig',
            [
                'comForm' => $form->createView(),
                'trick' => $trick, 'messages' => $messages

            ]


        );
    }

    #[Route('/create', name: 'app_create_trick')]
    public function createTrick(TrickRepository $trick, Request $request, EntityManagerInterface $entityManager)
    {
        $trick = new Trick;
        $user = $this->getUser();
        $form = $this->createForm(CreateTrickFormType::class, $trick);
        $form->handleRequest($request);

        if ($form->isSubmitted() and $form->isValid()) {
            //Get medias from form
            $medias = $form->get('media')->getData();
            foreach ($medias as $media) {
                $mediaName = md5(uniqid()) . '.' . $media->guessExtension();
                $media->move($this->getParameter('media_directory'), $mediaName);

                $newMedia = new Media;
                $newMedia->setMediaName($mediaName);
                $trick->addMedium($newMedia);
            }

            $trick->setAuthor($user);
            $trickName = $form->get('trick_name')->getData();
            $trickNameNoSpace = $trickName ? new UnicodeString(str_replace('-', ' ', $trickName)) : null;
            $trickSlug = strtolower($trickNameNoSpace);
            $trick->setSlug($trickSlug);
            $entityManager->persist($trick);
            $entityManager->flush();
            $this->addFlash('success', 'Votre nouveau Trick a été publié');
        }

        return $this->render(
            'tricks/create_trick.html.twig',
            [
                'createTrickForm' => $form->createView(), 'trick' => $trick
            ]
        );
    }

    #[Route('trick/modify/{slug}', name: 'app_modify_trick')]
    public function modifyTrick(Trick $trick, Request $request, EntityManagerInterface $entityManager)
    {

        $form = $this->createForm(ModifyTrickFormType::class, $trick);
        $form->handleRequest($request);
        if ($form->isSubmitted() and $form->isValid()) {
            //Get medias from form
            $medias = $form->get('media')->getData();
            foreach ($medias as $media) {
                $mediaName = md5(uniqid()) . '.' . $media->guessExtension();
                $media->move($this->getParameter('media_directory'), $mediaName);

                $newMedia = new Media;
                $newMedia->setMediaName($mediaName);
                $trick->addMedium($newMedia);
            }
            //$trickName = $form->get('trick_name')->getData();
            //$trickNameNoSpace = $trickName ? new UnicodeString(str_replace('-', ' ', $trickName)) : null;
            //$trickSlug = strtolower($trickNameNoSpace);
            // $trick->setSlug($trickSlug);
            $entityManager->persist($trick);
            $entityManager->flush();
            $this->addFlash('success', 'Trick modifié');
            $currentSlug = $request->get('slug');
            return $this->redirectToRoute('app_trick', ['slug' => $currentSlug]);
        }
        return $this->render(
            'tricks/modify_trick.html.twig',
            [
                'ModifyTrickForm' => $form->createView(), 'trick' => $trick
            ]
        );
    }
    #[Route('media/remove/{id}', name: 'app_remove_media')]
    public function deleteMedia(Media $media, Request $request, EntityManagerInterface $em)
    {
        $data = json_decode($request->getContent(), true);
        if ($this->isCsrfTokenValid('delete' . $media->getId(), $data['_token'])) {
            $mediaName = $media->getMediaName();
            unlink($this->getParameter('media_directory') . '/' . $mediaName);
            $em->remove($media);
            $em->flush();
            return new JsonResponse(['success' => 1]);
        } else {
            return new JsonResponse(['error' => 'Token invalide'], 400);
        }
    }
}
