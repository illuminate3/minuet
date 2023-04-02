<?php

declare(strict_types=1);

namespace App\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;

final class SettingsType extends AbstractType
{
    private const CHOICES = [
        'option.off' => '0',
        'option.on' => '1',
    ];

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('site_name', null, [
                'label' => 'label.site_name',
                'attr' => [
                    'autofocus' => true,
                    'placeholder' => 'label.site_name',
                    'class' => 'form-control',
                ],
                'constraints' => [
                    new Length(['min' => 2]),
                ],
            ])
            ->add('site_title', null, [
                'label' => 'label.site_title',
                'attr' => [
                    'placeholder' => 'label.site_title',
                    'class' => 'form-control',
                ],
                'required' => false,
                'constraints' => [
                    new Length(['min' => 2]),
                ],
            ])
            ->add('meta_description', TextareaType::class, [
                'label' => 'label.site_meta_description',
                'attr' => [
                    'placeholder' => 'label.site_meta_description',
                    'class' => 'form-control',
                ],
                'required' => false,
                'constraints' => [
                    new Length(['min' => 8]),
                ],
            ])
            ->add('meta_keywords', TextareaType::class, [
                'label' => 'label.site_meta_keywords',
                'attr' => [
                    'placeholder' => 'label.site_meta_keywords',
                    'class' => 'form-control',
                ],
                'required' => false,
                'constraints' => [
                    new Length(['min' => 8]),
                ],
            ])
            ->add('meta_author', TextareaType::class, [
                'label' => 'label.site_meta_author',
                'attr' => [
                    'placeholder' => 'label.site_meta_author',
                    'class' => 'form-control',
                ],
                'required' => false,
                'constraints' => [
                    new Length(['min' => 8]),
                ],
            ])
            ->add('meta_revisit', null, [
                'label' => 'label.site_meta_revisit',
                'attr' => [
                    'placeholder' => 'label.site_meta_revisit',
                    'class' => 'form-control',
                ],
                'required' => false,
                'constraints' => [
                    new Length(['min' => 1]),
                ],
            ])
            ->add('site_branding', TextareaType::class, [
                'label' => 'label.site_branding',
                'attr' => [
                    'placeholder' => 'label.site_branding',
                    'class' => 'form-control',
                ],
                'required' => false,
                'constraints' => [
                    new Length(['min' => 8]),
                ],
            ])
            ->add('analytics_code', TextareaType::class, [
                'label' => 'label.analytics_code',
                'attr' => [
                    'placeholder' => 'label.analytics_code',
                    'class' => 'form-control',
                ],
                'required' => false,
                'constraints' => [
                    new Length(['min' => 8]),
                ],
            ])
            ->add('allow_register', ChoiceType::class, [
                    'label' => 'label.site_allow_register',
                    'choices' => self::CHOICES,
                ]
            )
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([]);
    }
}
