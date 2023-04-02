<?php

declare(strict_types=1);

namespace App\Form\Type;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType as SymfonyPasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

final class UserType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add(
                'roles', ChoiceType::class, [
                    'choices' => [
                        'label.roles.admin' => 'ROLE_ADMIN',
                    ],
                    'label_attr' => [
                        'class' => 'form-control',
                    ],
                    'required' => false,
                    'expanded' => true,
                    'multiple' => true,
                    'label' => false,
                ]
            )
            ->add('email_verified', CheckboxType::class, [
                    'label' => 'label.email_verified',
                    'label_attr' => [
                        'class' => 'custom-control-label',
                    ],
                    'mapped' => false,
                    'required' => false,
                    'data' => null !== $options['data']->getEmailVerifiedAt(),
                ]
            )
            ->add('email', TextType::class, [
                'label' => 'label.email',
                'attr' => [
                    'placeholder' => 'label.email',
                    'class' => 'form-control',
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'validate.not.blank',
                    ]),
                ],
            ])
            ->add('password', SymfonyPasswordType::class, [
                'label' => 'label.password',
                'attr' => [
                    'placeholder' => 'label.password',
                    'class' => 'form-control',
                ],
                'required' => false,
            ])
            ->add('profile', ProfileType::class)
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
