<?php

declare(strict_types=1);

namespace App\Form\Type;

use App\Validator\ConfirmPassword;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType as SymfonyPasswordType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;

final class PasswordType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('password', SymfonyPasswordType::class, [
                'label' => 'label.password_new',
                'attr' => [
                    'autofocus' => true,
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
            ->add('password_confirmation', SymfonyPasswordType::class, [
                'label' => 'label.password_confirm',
                'constraints' => [
                    new Length([
                        'min' => 5,
                    ]),
                    new ConfirmPassword(),
                ],
            ]);
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([]);
    }
}
