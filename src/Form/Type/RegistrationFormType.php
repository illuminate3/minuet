<?php

declare(strict_types=1);

namespace App\Form\Type;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType as SymfonyPasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;

final class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', EmailType::class, [
                'label' => 'label.email',
                'attr' => [
                    'placeholder' => 'label.email',
                ],
            ])
            ->add('agreeTerms', CheckboxType::class, [
                'label' => 'label.agree',
                'mapped' => false,
                'constraints' => [
                    new IsTrue([
                        'message' => 'validate.agree.terms',
                    ]),
                ],
            ])
            ->add('password', SymfonyPasswordType::class, [
                'label' => 'label.password',
                'attr' => [
                    'autocomplete' => 'new-password',
                    'placeholder' => 'label.password',
                ],
                'constraints' => [
                    new Length([
                        'min' => 8,
                        'max' => 4096,
                    ]),
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
            'csrf_token_id' => 'authenticate',
        ]);
    }
}
