<?php

namespace App\Form\Type;

use App\Entity\Subscription;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class SubscriptionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('plan', TextType::class, [
                'label' => 'label.plan',
                'attr' => [
                    'placeholder' => 'label.plan',
                    'class' => 'form-control',
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'validate.not.blank',
                    ]),
                ],
            ])
            ->add('price', MoneyType::class, options: [
                'label' => 'label.price',
                'currency' => 'USD',
                'divisor' => 1,
                'constraints' => [
                    //                    new Positive([
                    //                        'message' => 'validate.not.negative',
                    //                    ]),
                    new NotBlank([
                        'message' => 'validate.not.blank',
                    ]),
                ],
            ])
            ->add('valid_until', TextType::class, [
                'label' => 'label.valid_until',
                'attr' => [
                    'placeholder' => 'label.valid_until',
                    'class' => 'form-control',
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'validate.not.blank',
                    ]),
                    new Length([
                        'min' => 5,
                        'max' => 20,
                    ]),
                ],
            ])
            ->add('availability', TextType::class, [
                'label' => 'label.availability',
                'attr' => [
                    'placeholder' => 'label.availability',
                    'class' => 'form-control',
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'validate.not.blank',
                    ]),
                    new Length([
                        'min' => 5,
                        'max' => 20,
                    ]),
                ],
            ])
            ->add('support', TextType::class, [
                'label' => 'label.support',
                'attr' => [
                    'placeholder' => 'label.support',
                    'class' => 'form-control',
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'validate.not.blank',
                    ]),
                    new Length([
                        'min' => 5,
                        'max' => 20,
                    ]),
                ],
            ])
            ->add('stripe_price_id', TextType::class, [
                'label' => 'label.stripe_price_id',
                'attr' => [
                    'placeholder' => 'label.stripe_price_id',
                    'class' => 'form-control',
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'validate.not.blank',
                    ]),
                    new Length([
                        'min' => 5,
                        'max' => 45,
                    ]),
                ],
            ])

        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Subscription::class,
        ]);
    }
}
