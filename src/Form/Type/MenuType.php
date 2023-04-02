<?php

declare(strict_types=1);

namespace App\Form\Type;

use App\Entity\Menu;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

final class MenuType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, [
                'label' => 'label.link_text',
                'attr' => [
                    'autofocus' => true,
                    'class' => 'form-control',
                ],
            ])
            ->add('isSlug', CheckboxType::class, [
                'label' => 'label.isSlug',
                'attr' => [
                    'class' => 'form-check-input',
                ],
                'label_attr' => [
                    'class' => 'custom-control-label',
                ],
                'required' => false,
            ])
            ->add('url', TextType::class, [
                'label' => 'label.url',
                'attr' => [
                    'class' => 'form-control',
                ],
            ])
            ->add('nofollow', CheckboxType::class, [
                'label' => 'label.nofollow',
                'attr' => [
                    'class' => 'form-check-input',
                ],
                'label_attr' => [
                    'class' => 'custom-control-label',
                ],
                'required' => false,
            ])
            ->add('new_tab', CheckboxType::class, [
                'label' => 'label.new_tab',
                'attr' => [
                    'class' => 'form-check-input',
                ],
                'label_attr' => [
                    'class' => 'custom-control-label',
                ],
                'required' => false,
            ])
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Menu::class,
        ]);
    }
}
