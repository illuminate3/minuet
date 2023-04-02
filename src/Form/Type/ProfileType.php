<?php

declare(strict_types=1);

namespace App\Form\Type;

use App\Entity\Profile;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotNull;

final class ProfileType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('full_name', null, [
                'label' => 'label.full_name',
                'attr' => [
                    'placeholder' => 'label.full_name',
                    'class' => 'form-control',
                ],
                'constraints' => [
                    new NotNull(),
                ],
            ])
            ->add('phone', null, [
                'label' => 'label.phone',
                'attr' => [
                    'placeholder' => 'label.phone',
                    'class' => 'form-control',
                ],
                'constraints' => [
                    new NotNull(),
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
