<?php

namespace App\Form;

use App\Entity\Delivery;
use App\Entity\Product;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('firstname')
            ->add('lastname')
            ->add('adress')
            ->add('complementadress')
            ->add('city')
            ->add('postalcode')
            ->add('country', ChoiceType::class, [
                'choices' => $this->fieldChoices(),
            ])

            ->add('phonenumber')
            ->add('email',RepeatedType::class, [
                'type' => EmailType::class,
                'invalid_message' => 'votre email n\'est pas valide',
                'options' => ['attr' => ['class' => 'email-field']],
                'required' => true,
                'first_options'  => ['label' => 'Email'],
                'second_options' => ['label' => 'Confirmation email'],
            ])
           
            ->add('delivery', DeliveryType::class)
            
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
    private function fieldChoices()
    {
        return [
            'France' => 'FR',
            'Switzerland' => 'CH',
            'Belgium' => 'BE',
        ];
    }
}
