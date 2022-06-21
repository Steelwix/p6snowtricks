<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\UnicodeString;

class TricksController
{
    #[Route('/')]
    public function homepage(): Response
    {
        return new Response('Yo');
    }
    #[Route('/browse/{slug}')]
    public function browse(string $slug = null): Response
    {
        if ($slug) {
            $trickTitle = new UnicodeString(str_replace('-', ' ', $slug));
        } else {
            $trickTitle = 'All tricks';
        }
        return new Response('Pick a Trick ' . $trickTitle);
    }
}
