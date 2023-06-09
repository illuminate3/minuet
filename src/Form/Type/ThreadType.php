<?php

namespace App\Form\Type;

use App\Entity\Thread;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ThreadType extends AbstractType
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
            ->add('isClosed')
            ->add('isPin')
            ->add('totalMessages')
            ->add('created_at')
            ->add('product')
            ->add('user')
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
            'data_class' => Thread::class,
        ]);
    }

}
