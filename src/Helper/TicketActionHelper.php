<?php

namespace App\Helper;

use App\Entity\Ticket;
use App\Enum\TicketStatusEnums;
use App\Form\AdminTicketFormType;
use App\Form\TicketFormType;
use App\Repository\StatusRepository;
use App\Repository\TicketRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class TicketActionHelper extends AbstractController
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        private TicketRepository $ticketRepository,
        private StatusRepository $statusRepository
    ) {
    }

    public function getAllTickets(): array
    {
        return $this->ticketRepository->findTicketsByUser($this->getUser()->getId());
    }

    public function createTicket(Request $request): array
    {
        $ticket = new Ticket();
        $message = '';
        $form = $this->createForm(TicketFormType::class, $ticket);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $newTicket = $form->getData();
            $statusType = $this->statusRepository->find(TicketStatusEnums::Unresolved->value);
            $dateCreated = new \DateTime();
            $user = $this->getUser();

            $newTicket->setUser($user);
            $newTicket->setDateCreated($dateCreated);
            $newTicket->setStatus($statusType);

            $this->entityManager->persist($newTicket);
            $this->entityManager->flush();

            $message = 'Ticket has created successfully';
        }

        return [
            'form' => $form,
            'message' => $message
        ];
    }

    public function getTicketById(int $id): Ticket
    {
        return $this->ticketRepository->find($id);
    }

    public function updateTicket(int $id, Request $request): array
    {
        $ticket = $this->ticketRepository->find($id);
        $message = '';

        $form = $this->createForm(TicketFormType::class, $ticket);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $newSubject = $form->get('subject')->getData();
            $newDescription = $form->get('description')->getData();

            $ticket->setSubject($newSubject);
            $ticket->setDescription($newDescription);

            $this->entityManager->flush();

            $message = 'Ticket has been updated successfully';
        }

        return [
            'form' => $form,
            'message' => $message
        ];
    }

    public function updateTicketByAdmin(int $id, Request $request): array
    {
        $ticket = $this->ticketRepository->find($id);
        $message = '';

        $form = $this->createForm(AdminTicketFormType::class, $ticket);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $newSubject = $form->get('subject')->getData();
            $newDescription = $form->get('description')->getData();
            $newStatus = $form->get('status')->getData();

            $ticket->setSubject($newSubject);
            $ticket->setDescription($newDescription);
            $ticket->setStatus($newStatus);

            $this->entityManager->flush();

            $message = 'Ticket has been updated successfully';
        }

        return [
            'form' => $form,
            'message' => $message
        ];
    }

    public function deleteTicket(int $id)
    {
        $ticket = $this->ticketRepository->find($id);
        $this->entityManager->remove($ticket);
        $this->entityManager->flush();
    }
}
