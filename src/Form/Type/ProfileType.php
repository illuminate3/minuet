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
     * @param  FormBuilderInterface  $builder
     * @param  array                 $options
     *
     * @return void
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
        ;
    }


    /**
     * @param  OptionsResolver  $resolver
     *
     * @return void
     */
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Profile::class,
        ]);
    }

}
