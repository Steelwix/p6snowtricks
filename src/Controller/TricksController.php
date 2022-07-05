<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\UnicodeString;

class TricksController extends AbstractController
{
    #[Route('/')]
    public function homepage(): Response
    {
        return $this->render('tricks/homepage.html.twig', [
            'title' => 'Snow Triks',
        ]);
    }
    #[Route('/browse/{slug}')]
    public function browse(string $slug = null): Response
    {
        if ($slug) {
            $trickTitle = new UnicodeString(str_replace('-', ' ', $slug));
        } else {
            $trickTitle = 'All tricks';
        }
        return new Response('How to do the ' . $trickTitle);
    }
}
