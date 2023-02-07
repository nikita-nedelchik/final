<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;

class ProfileController extends AbstractController
{
    #[Route(path: '/profile', name: 'profile_index')]
    public function profile(UserInterface $user): Response
    {
        return $this->render('/profile/index.html.twig', [
            'user' => $user,
            'isAdmin' => in_array('ROLE_ADMIN', $user->getRoles())
        ]);
    }
}
