<?php

namespace App\Form;

use App\Entity\Device;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DeviceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('type', TextType::class)
            ->add('refDevice', TextType::class)
            ->add('mark', TextType::class)
            ->add('guarantee', ChoiceType::class, ['label' => 'Garantie', 'expanded'=>true, 'choices' => [
                'Oui' => true,
                'Non' => false
                ]])
            ->add('beSame', ChoiceType::class ,['label' => 'Montage perso', 'expanded'=>true, 'choices' => [
                'Oui' => true,
                'Non' => false
                ]])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Device::class,
        ]);
    }
}
