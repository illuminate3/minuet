<?php

declare(strict_types=1);

namespace App\Form\Type;

use App\Entity\Product;
use App\Entity\Category;
use App\Repository\CategoryRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProductType extends AbstractType
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
            ->add('vin', TextType::class, [
                'label' => 'label.vehicle_identification_number',
                'attr' => [
                    'placeholder' => 'label.vehicle_identification_number',
                    'class' => 'form-control',
                ],
                'required' => true,
                'mapped' => true,
            ])
            ->add('title', TextType::class, [
                'label' => 'label.title',
                'attr' => [
                    'placeholder' => 'label.title',
                    'class' => 'form-control',
                ],
                'mapped' => true,
                'required' => true,
            ])
            ->add('description', TextType::class, [
                'label' => 'label.description',
                'attr' => [
                    'placeholder' => 'label.description',
                    'class' => 'form-control',
                ],
                'mapped' => true,
                'required' => false,
            ])
            ->add('price', TextType::class, [
                'label' => 'label.price',
                'attr' => [
                    'placeholder' => 'label.price',
                    'class' => 'form-control',
                ],
                'mapped' => true,
                'required' => false,
            ])
            ->add('category', EntityType::class, [
                'class' => Category::class,
                'placeholder' => 'label.category',
                'choice_label' => 'name',
                'label' => 'label.category',
                'mapped' => true,
                'required' => false,
                'group_by' => 'parent.name',
                'query_builder' => function (CategoryRepository $cr) {
                    return $cr->createQueryBuilder('c')
                        ->where('c.parent IS NOT NULL')
                        ->orderBy('c.name', 'ASC')
                    ;
                },
            ])
            ->add('images', FileType::class, [
                'label' => false,
                'mapped' => false,
                'required' => false,
            ])
        ;
        $builder->get('vin')->setRequired(true);
        $builder->get('title')->setRequired(true);
        $builder->get('images')->setRequired(true);
        $builder->get('category')->setRequired(true);
        $builder->get('description')->setRequired(true);
        $builder->get('price')->setRequired(true);
    }


    /**
     * @param  OptionsResolver  $resolver
     *
     * @return void
     */
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Product::class,
        ]);
    }

}
