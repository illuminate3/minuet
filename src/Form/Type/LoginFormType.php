<?php

declare(strict_types=1);

namespace App\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType as SymfonyPasswordType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

final class LoginFormType extends AbstractType
{
    private AuthenticationUtils $helper;

    public function __construct(AuthenticationUtils $helper)
    {
        $this->helper = $helper;
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
            ->add('email', EmailType::class, [
                'label' => 'label.email',
                'attr' => [
                    'placeholder' => 'label.email',
                ],
                'data' => $this->helper->getLastUsername(),
            ])
            ->add('password', SymfonyPasswordType::class, [
                'label' => 'label.password',
                'attr' => [
                    'placeholder' => 'label.password',
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
            'csrf_field_name' => '_csrf_token',
            'csrf_token_id' => 'authenticate',
        ]);
    }

}
