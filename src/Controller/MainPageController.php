<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainPageController extends AbstractController
{
    #[Route('/', name: 'index_page')]
    public function index(): Response
    {
        return $this->render('index.html.twig', [
            'title' => 'The main page'
        ]);
    }
}
