<?php

namespace App\Controller;

use App\Entity\Message;
use App\Entity\Trick;
use App\Entity\User;
use App\Form\CommentaryFormType;
use App\Repository\MessageRepository;
use App\Repository\UserRepository;
use App\Repository\TrickRepository;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;



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
    #[Route('/{slug}', name: 'app_trick')]
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
            return $this->redirectToRoute('app_home_');
        }

        return $this->render(
            'tricks/tricks.html.twig',
            [
                'comForm' => $form->createView(),
                'trick' => $trick, 'messages' => $messages

            ]


        );
    }
}
