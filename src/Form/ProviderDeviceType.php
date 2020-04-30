<?php

namespace App\Form;

use App\Entity\ProviderDevice;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProviderDeviceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('provider', EntityType::class, [
            'class'  => 'App:ServiceProvider',
            'choice_label' => 'name',
        ])
        ->add('repair_id', HiddenType::class)
        ;
        
        
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => ProviderDevice::class,
        ]);
    }
}
