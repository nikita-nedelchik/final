<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('first_name', TextType::class, [
                'required' => false,
                'label_attr' => [
                    'class' => 'required'
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Please enter a first name'
                    ])
                ]
            ])
            ->add('last_name', TextType::class, [
                'required' => false,
                'label_attr' => [
                    'class' => 'required'
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Please enter a last name'
                    ])
                ]
            ])
            ->add('username', TextType::class, [
                'required' => false,
                'label_attr' => [
                    'class' => 'required'
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Please enter a username'
                    ]),
                    new Length([
                        'min' => 3,
                        'minMessage' => 'Your password should be at least {{ limit }} characters',
                        'max' => 50,
                    ]),
                ]
            ])
            ->add('email', EmailType::class, [
                'required' => false,
                'label_attr' => [
                    'class' => 'required'
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Please enter an email'
                    ])
                ]
            ])
            ->add('plainPassword', RepeatedType::class, [
                // instead of being set onto the object directly,
                // this is read and encoded in the controller
                'first_name' => 'Password',
                'second_name' => 'Confirm_password',
                'type' => PasswordType::class,
                'required' => false,
                'mapped' => false,
                'first_options'  => [
                    'label_attr' => [
                        'class' => 'required'
                    ],
                ],
                'second_options' => [
                    'label_attr' => [
                        'class' => 'required'
                    ],
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Please enter a password',
                    ]),
                    new Length([
                        'min' => 6,
                        'minMessage' => 'Your password should be at least {{ limit }} characters',
                        // max length allowed by Symfony for security reasons
                        'max' => 4096,
                    ]),
                ],
            ])
            ->add('register', SubmitType::class, [
                'attr' => [
                    'class' => 'btn-primary w-100',
                    'type' => 'submit'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
