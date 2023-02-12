<?php

namespace App\Form;

use App\Entity\Ticket;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class TicketFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('subject', TextType::class, [
                'required' => false,
                'label_attr' => [
                    'class' => 'required'
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Please enter a subject'
                    ])
                ]
            ])
            ->add('description', TextareaType::class, [
                'required' => false,
                'label_attr' => [
                    'class' => 'required'
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Please enter a description of the ticket'
                    ]),
                    new Length([
                        'min' => 10,
                        'minMessage' => 'Your description should be at least {{ limit }} characters',
                        'max' => 4096,
                    ])
                ]
            ])
            ->add('Submit', SubmitType::class, [
                'attr' => [
                    'class' => 'btn-primary w-100',
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Ticket::class,
        ]);
    }
}
