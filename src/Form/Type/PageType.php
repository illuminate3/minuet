<?php

declare(strict_types=1);

namespace App\Form\Type;

use App\Entity\Page;
use App\Utils\Slugger;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

final class PageType extends AbstractType
{
    // Form types are services, so you can inject other services if needed
    public function __construct(
        private Slugger $slugger
    ) {
    }


    /**
     * @param  FormBuilderInterface  $builder
     * @param  array                 $options
     *
     * @return void
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('show_in_menu', CheckboxType::class, [
                'label' => 'label.show_in_menu',
                'attr' => [
                    'class' => 'form-check-input',
                ],
                'label_attr' => [
                    'class' => 'custom-control-label',
                ],
                'required' => false,
            ])
            ->add('publish', CheckboxType::class, [
                'label' => 'label.publish',
                'attr' => [
                    'class' => 'form-check-input',
                ],
                'label_attr' => [
                    'class' => 'custom-control-label',
                ],
                'required' => false,
            ])
            ->add('title', TextType::class, [
                'label' => 'label.title',
                'attr' => [
                    'placeholder' => 'label.title',
                    'class' => 'form-control',
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'validate.not.blank',
                    ]),
                ],
            ])
            ->add('slug', null, [
                'label' => 'label.slug',
                'attr' => [
                    'placeholder' => 'label.slug',
                    'class' => 'form-control',
                ],
                'disabled' => true,
                'required' => false,
            ])
            ->add('description', TextareaType::class, [
                'label' => 'label.description',
                'attr' => [
                    'placeholder' => 'label.description',
                    'class' => 'form-control',
                ],
            ])
            ->add('content', CKEditorType::class, [
                'label' => 'label.content',
                'attr' => [
                    'placeholder' => 'label.content',
                    'class' => 'form-control',
                    'rows' => '7',
                ],
                'required' => false,
            ])
            // form events let you modify information or fields at different steps
            // of the form handling process.
            // See https://symfony.com/doc/current/form/events.html
            ->addEventListener(FormEvents::SUBMIT, function (FormEvent $event): void {
                $page = $event->getData();
                if ($page->getTitle() !== null) {
                    $page->setSlug($this->slugger->slugify($page->getTitle()));
                }
            })
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
            'csrf_protection' => true,
            'data_class' => Page::class,
        ]);
    }

}
