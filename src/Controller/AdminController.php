<?php

namespace App\Controller;

use App\Helper\TicketActionHelper;
use App\Repository\TicketRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{
    #[Route(path: '/admin', name: 'admin_index')]
    public function admin(): Response
    {
        return $this->redirectToRoute('admin_tickets');
    }

    #[Route(path: '/admin/tickets', name: 'admin_tickets')]
    public function ticketsAdmin(TicketRepository $ticketRepository): Response
    {
        return $this->render('/admin/tickets.html.twig', [
            'tickets' => $ticketRepository->findAll()
        ]);
    }

    #[Route(path: '/admin/tickets/{id}')]
    public function ticketChangeStatus(TicketActionHelper $actionHelper, int $id, Request $request): Response
    {
        $data = $actionHelper->updateTicketByAdmin($id, $request);

        return $this->render('/admin/ticket_update.html.twig', [
            'form' => $data['form']->createView(),
            'message' => $data['message']
        ]);
    }
}
