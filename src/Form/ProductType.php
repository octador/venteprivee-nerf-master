<?php

namespace App\Form;

use App\Entity\Delivery;
use App\Entity\Media;
use App\Entity\Product;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProductType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name')
            ->add('price')
            ->add('quantity')
            ->add('createdAt', null, [
                'widget' => 'single_text',
            ])
            ->add('quantityoffer')
            ->add('ispopular')
            ->add('reduction')
            // ->add('media', EntityType::class, [
            //     'class' => Media::class,
            //     'choice_label' => 'id',
            // ])
            // ->add('delivery', EntityType::class, [
            //     'class' => Delivery::class,
            //     'choice_label' => 'id',
            // ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Product::class,
        ]);
    }
}
