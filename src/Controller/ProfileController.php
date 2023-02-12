<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProfileController extends AbstractController
{
    #[Route(path: '/profile', name: 'profile_index')]
    public function profile(): Response
    {
        return $this->render('/profile/index.html.twig', [
            'user' => $this->getUser(),
            'isAdmin' => in_array('ROLE_ADMIN', $this->getUser()->getRoles())
        ]);
    }
}
