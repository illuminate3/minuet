<?php

declare(strict_types=1);

namespace App\Form\Type;

use App\Entity\Profile;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotNull;

final class ProfileType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('first_name', TextType::class, [
                'label' => 'label.first_name',
                'attr' => [
                    'autofocus' => true,
                    'placeholder' => 'label.first_name',
                    'class' => 'form-control',
                ],
                'constraints' => [
                    new Length(['min' => 2]),
                    new NotNull(),
                ],
            ])
            ->add('last_name', TextType::class, [
                'label' => 'label.last_name',
                'attr' => [
                    'autofocus' => true,
                    'placeholder' => 'label.last_name',
                    'class' => 'form-control',
                ],
                'constraints' => [
                    new Length(['min' => 2]),
                    new NotNull(),
                ],
            ])
            ->add('phone', null, [
                'label' => 'label.phone',
                'attr' => [
                    'placeholder' => 'label.phone',
                    'class' => 'form-control',
                ],
                'required' => false,
                'constraints' => [
                    new Length(['min' => 10]),
                ],
            ])
            ->add('state', ChoiceType::class, [
                'label' => 'label.state',
                'attr' => [
                    'class' => 'form-control',
                ],
                'required' => false,
                'placeholder' => 'text.select',
                'choices' => [
                    'Alabama' => 'AL',
                    'Alaska' => 'AK',
                    'Arizona' => 'AZ',
                    'Arkansas' => 'AR',
                    'California' => 'CA',
                    'Colorado' => 'CO',
                    'Connecticut' => 'CT',
                    'Delaware' => 'DE',
                    'Florida' => 'FL',
                    'Georgia' => 'GA',
                    'Hawaii' => 'HI',
                    'Idaho' => 'ID',
                    'Illinois' => 'IL',
                    'Indiana' => 'IN',
                    'Iowa' => 'IA',
                    'Kansas' => 'KS',
                    'Kentucky' => 'KY',
                    'Louisiana' => 'LA',
                    'Maine' => 'ME',
                    'Maryland' => 'MD',
                    'Massachusetts' => 'MA',
                    'Michigan' => 'MI',
                    'Minnesota' => 'MN',
                    'Mississippi' => 'MS',
                    'Missouri' => 'MO',
                    'Montana' => 'MT',
                    'Nebraska' => 'NE',
                    'Nevada' => 'NV',
                    'New Hampshire' => 'NH',
                    'New Jersey' => 'NJ',
                    'New Mexico' => 'NM',
                    'New York' => 'NY',
                    'North Carolina' => 'NC',
                    'North Dakota' => 'ND',
                    'Ohio' => 'OH',
                    'Oklahoma' => 'OK',
                    'Oregon' => 'OR',
                    'Pennsylvania' => 'PA',
                    'Rhode Island' => 'RI',
                    'South Carolina' => 'SC',
                    'South Dakota' => 'SD',
                    'Tennessee' => 'TN',
                    'Texas' => 'TX',
                    'Utah' => 'UT',
                    'Vermont' => 'VT',
                    'Virginia' => 'VA',
                    'Washington' => 'WA',
                    'West Virginia' => 'WV',
                    'Wisconsin' => 'WI',
                    'Wyoming' => 'WY',
                ],
            ])
            ->add('address_street', TextType::class, [
                'label' => 'label.address_street',
                'attr' => [
                    'placeholder' => 'label.address_street',
                    'class' => 'form-control',
                ],
                'required' => false,
                'constraints' => [
                    new Length(['min' => 5]),
                ],
            ])
            ->add('address_unit', TextType::class, [
                'label' => 'label.address_unit',
                'attr' => [
                    'placeholder' => 'label.address_unit',
                    'class' => 'form-control',
                ],
                'required' => false,
                'constraints' => [
                    new Length(['min' => 2]),
                ],
            ])
            ->add('city', TextType::class, [
                'label' => 'label.city',
                'attr' => [
                    'placeholder' => 'label.city',
                    'class' => 'form-control',
                ],
                'required' => false,
                'constraints' => [
                    new Length(['min' => 2]),
                ],
            ])
            ->add('post_code', TextType::class, [
                'label' => 'label.post_code',
                'attr' => [
                    'placeholder' => 'label.post_code',
                    'class' => 'form-control',
                ],
                'required' => false,
                'constraints' => [
                    new Length(['min' => 5]),
                ],
            ])
            ->add('display_email', TextType::class, [
                'label' => 'label.display_email',
                'attr' => [
                    'placeholder' => 'label.display_email',
                    'class' => 'form-control',
                ],
                'required' => false,
                'constraints' => [
                    new Length(['min' => 6]),
                ],
            ])
            ->add('website', TextType::class, [
                'label' => 'label.website',
                'attr' => [
                    'placeholder' => 'label.website',
                    'class' => 'form-control',
                ],
                'required' => false,
                'constraints' => [
                    new Length(['min' => 6]),
                ],
            ])
            ->add('facebook', TextType::class, [
                'label' => 'label.facebook',
                'attr' => [
                    'placeholder' => 'label.facebook',
                    'class' => 'form-control',
                ],
                'required' => false,
                'constraints' => [
                    new Length(['min' => 6]),
                ],
            ])
            ->add('twitter', TextType::class, [
                'label' => 'label.twitter',
                'attr' => [
                    'placeholder' => 'label.twitter',
                    'class' => 'form-control',
                ],
                'required' => false,
                'constraints' => [
                    new Length(['min' => 6]),
                ],
            ])
            ->add('linkedin', TextType::class, [
                'label' => 'label.linkedin',
                'attr' => [
                    'placeholder' => 'label.linkedin',
                    'class' => 'form-control',
                ],
                'required' => false,
                'constraints' => [
                    new Length(['min' => 6]),
                ],
            ])
            ->add('instagram', TextType::class, [
                'label' => 'label.instagram',
                'attr' => [
                    'placeholder' => 'label.instagram',
                    'class' => 'form-control',
                ],
                'required' => false,
                'constraints' => [
                    new Length(['min' => 6]),
                ],
            ])
            ->add('pinterest', TextType::class, [
                'label' => 'label.pinterest',
                'attr' => [
                    'placeholder' => 'label.pinterest',
                    'class' => 'form-control',
                ],
                'required' => false,
                'constraints' => [
                    new Length(['min' => 6]),
                ],
            ])
            ->add('youtube', TextType::class, [
                'label' => 'label.youtube',
                'attr' => [
                    'placeholder' => 'label.youtube',
                    'class' => 'form-control',
                ],
                'required' => false,
                'constraints' => [
                    new Length(['min' => 6]),
                ],
            ])
            ->add('banner', TextType::class, [
                'label' => 'label.banner',
                'attr' => [
                    'placeholder' => 'label.banner',
                    'class' => 'form-control',
                ],
                'required' => false,
                'constraints' => [
                    new Length(['min' => 6]),
                ],
            ])

        ;
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Profile::class,
        ]);
    }
}
