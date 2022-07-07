<?php

namespace App\Controller;

use App\Entity\Trick;
use App\Repository\TrickRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;



class TricksController extends AbstractController
{
    #[Route('/', name: 'app_home_')]
    public function homepage(): Response
    {
        return $this->render('tricks/homepage.html.twig', [
            'title' => 'Snow Tricks',
        ]);
    }
    #[Route('/{slug}', name: 'tricks')]
    public function show(Trick $trick): Response
    {
        dd($trick);
        return $this->render(
            'tricks/tricks.html.twig'
        );
    }
}
