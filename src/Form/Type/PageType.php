<?php

declare(strict_types=1);

/**
 * Created by PhpStorm.
 * User: Valery Maslov
 * Date: 01.11.2018
 * Time: 11:13.
 */

namespace App\Form\Type;

use App\Entity\Page;
use App\Entity\Post;
use Nicolassing\QuillBundle\Form\Type\QuillType;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\LanguageType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;
//use Symfony\Component\String\Slugger\SluggerInterface;
use App\Utils\Slugger;
use Symfony\Component\Validator\Constraints\NotBlank;

final class PageType extends AbstractType
{
    // Form types are services, so you can inject other services in them if needed
    public function __construct(
        private Slugger $slugger
    ) {
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
//            ->add('locale', LanguageType::class)
//            ->add('locale', HiddenType::class, [
//                'data' => 'bg',
//            ])
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
//            ->add('locale', LanguageType::class)
            ->add('content', TextareaType::class, [
                'label' => 'label.content',
                'attr' => [
                    'placeholder' => 'label.content',
                    'class' => 'form-control quill',
                    'rows' => '7',
                ],
                'required' => false,
            ])
            // form events let you modify information or fields at different steps
            // of the form handling process.
            // See https://symfony.com/doc/current/form/events.html
            ->addEventListener(FormEvents::SUBMIT, function (FormEvent $event) {
                /** @var Page */
                $page = $event->getData();
                if ( $page->getTitle() !== null ) {

//                    $slug = $this->slugger->slugify($object->getTitle());
//                    $page->setSlug($this->slugger->slug($page->getTitle())->lower());
                    $page->setSlug($this->slugger->slugify($page->getTitle()));

                }
//                $page->setLocale('bg');
            })
        ;
//            ->add('add_contact_form', null, [
//                'attr' => [
//                    'class' => 'custom-control-input',
//                ],
//                'label' => 'label.add_contact_form',
//                'label_attr' => [
//                    'class' => 'custom-control-label',
//                ],
//            ])
//            ->add('contact_email_address', null, [
//                'attr' => [
//                    'class' => 'form-control',
//                    'placeholder' => 'placeholder.enter_email',
//                ],
//                'label' => 'label.contact_email_address',
//            ]);
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'csrf_protection' => true,
            'data_class' => Page::class,
//            'constraints' => [
//                new UniqueEntity(['fields' => ['title']]),
//            ],
        ]);
    }
}
