<?php

namespace App\Controller;

use App\Entity\Trick;
use App\Entity\User;
use App\Repository\UserRepository;
use App\Repository\TrickRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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
        Trick $trick
    ): Response {

        return $this->render(
            'tricks/tricks.html.twig',
            compact('trick')

        );
    }
}
