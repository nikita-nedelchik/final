<?php

namespace App\Helper;

use App\Entity\Status;
use App\Enum\TicketStatusEnums;
use App\Form\TicketFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;

class TicketActionHelper extends AbstractController
{
    public function __construct(private EntityManagerInterface $entityManager)
    {
    }

    public function createTicket(Request $request): FormInterface
    {
        $form = $this->createForm(TicketFormType::class);
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
        }

        return $form;
    }
}
