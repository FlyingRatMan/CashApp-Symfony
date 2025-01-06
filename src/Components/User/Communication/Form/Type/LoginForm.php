<?php

declare(strict_types=1);

namespace App\Components\User\Communication\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type as FormType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;

class LoginForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', FormType\EmailType::class, [
                'label' => 'Email',
                'attr' => [
                    'class' => 'form_input',
                ],
                'constraints' => [
                    new Assert\NotBlank(['message' => 'Email is required']),
                    new Assert\Email(['message' => 'Email is not valid']),
                ],
            ])
            ->add('password', FormType\PasswordType::class, [
                'label' => 'Password',
                'attr' => [
                    'class' => 'form_input',
                ],
                'constraints' => [
                    new Assert\NotBlank(['message' => 'Password is required']),
                ],
            ])
            ->add('loginBtn', FormType\SubmitType::class, [
                'label' => 'Log in!',
                'attr' => [
                    'class' => 'form_primary-btn',
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
    }
}
