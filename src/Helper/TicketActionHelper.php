<?php

namespace App\Helper;

use App\Entity\Status;
use App\Entity\Ticket;
use App\Enum\TicketStatusEnums;
use App\Form\TicketFormType;
use App\Repository\TicketRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;

class TicketActionHelper extends AbstractController
{
    public function __construct(private EntityManagerInterface $entityManager, private TicketRepository $ticketRepository)
    {
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
            $statusType = TicketStatusEnums::Unresolved->value;
            $dateCreated = new \DateTime();
            $user = $this->getUser();

            $status = new Status();
            $status->addTicket($newTicket);
            $status->setType($statusType);

            $newTicket->setUser($user);
            $newTicket->setDateCreated($dateCreated);

            $this->entityManager->persist($status);
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

    public function deleteTicket(int $id)
    {
        $ticket = $this->ticketRepository->find($id);
        $this->entityManager->remove($ticket);
        $this->entityManager->flush();
    }
}
