<?php

namespace App\Controller;

use App\Entity\Ticket;
use App\Form\TicketFormType;
use App\Helper\TicketActionHelper;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TicketController extends AbstractController
{
    #[Route(path: '/tickets', name: 'index_ticket', methods: ['GET'])]
    public function indexTickets(): Response
    {
        $ticket = new Ticket();
        $form = $this->createForm(TicketFormType::class, $ticket);

        return $this->render('/ticket/create.html.twig', [
            'ticketForm' => $form->createView()
        ]);
    }

    #[Route(path: '/tickets', name: 'create_ticket', methods: ['POST'])]
    public function createTicket(TicketActionHelper $actionHelper, Request $request): Response
    {
        $form = $actionHelper->createTicket($request);

        return $this->render('/ticket/create.html.twig', [
            'ticketForm' => $form->createView(),
            'message' => $form->isSubmitted() && $form->isValid() ? 'Ticket has created successfully' : ''
        ]);
    }
}
