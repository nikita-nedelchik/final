<?php

namespace App\Controller;

use App\Helper\TicketActionHelper;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TicketController extends AbstractController
{
    #[Route(path: '/tickets', name: 'index_ticket', methods: ['GET'])]
    public function index(TicketActionHelper $helper): Response
    {

        return $this->render('/ticket/index.html.twig', [
            'tickets' => $helper->getAllTickets()
        ]);
    }

    #[Route(path: '/tickets/create', name: 'form_ticket', methods: ['GET', 'POST'])]
    public function formTicketsView(TicketActionHelper $actionHelper, Request $request): Response
    {
        $data = $actionHelper->createTicket($request);

        return $this->render('/ticket/create.html.twig', [
            'ticketForm' => $data['form']->createView(),
            'message' => $data['message']
        ]);
    }

    #[Route(path: '/tickets/{id}/update', methods: ['GET', 'POST'])]
    public function updateTicket(TicketActionHelper $actionHelper, int $id, Request $request): Response
    {
        $data = $actionHelper->updateTicket($id, $request);

        return $this->render('/ticket/update.html.twig', [
            'ticketForm' => $data['form']->createView(),
            'message' => $data['message']
        ]);
    }

    #[Route(path: '/tickets/{id}/delete', methods: ['GET'])]
    public function deleteTicket(TicketActionHelper $actionHelper, int $id): RedirectResponse
    {
        $actionHelper->deleteTicket($id);

        return $this->redirectToRoute('index_ticket');
    }
}
