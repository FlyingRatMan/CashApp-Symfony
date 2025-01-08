<?php

namespace App\Components\Account\Communication\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;

class AccountForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('amount', MoneyType::class, [
                'label' => 'Amount',
                'currency' => 'EUR',
                'attr' => [
                    'required' => true,
                    'class' => 'border border-gray-300 rounded-lg px-4 py-2 text-green-800 font-normal focus:outline-none focus:ring-2 focus:ring-green-400',
                ],
                'constraints' => [
                    new Assert\NotBlank(),
                    // new DailyLimit(),
                    // new HourlyLimit(),
                ],
            ])
            ->add('transfer', SubmitType::class, [
                'label' => 'Add money',
                'attr' => [
                    'class' => 'bg-green-400 text-white px-4 py-2 rounded-lg hover:bg-green-500',
                ],
                'constraints' => [
                    new Assert\NotBlank(),
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
    }
}