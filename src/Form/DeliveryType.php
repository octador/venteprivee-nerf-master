<?php

namespace App\Form;

use App\Entity\Delivery;
use App\Entity\Payment;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DeliveryType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('firstname')
            ->add('lastname')
            ->add('adress')
            ->add('complement')
            ->add('city')
            ->add('postalcode')
            ->add('country', ChoiceType::class, [
                'choices' => $this->fieldChoices(),
            ])
            ->add('phonenumber')
            ->add('isstatusdelivery')
            ->add('createdAt', null, [
                'widget' => 'single_text',
            ])
            ->add('isstatuspayment')
            ->add('user', EntityType::class, [
                'class' => User::class,
                'choice_label' => 'id',
            ])
            ->add('payment', EntityType::class, [
                'class' => Payment::class,
                'choice_label' => 'id',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Delivery::class,
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
