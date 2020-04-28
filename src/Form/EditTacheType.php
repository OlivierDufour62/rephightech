<?php

namespace App\Form;

use App\Entity\Repair;
use App\Entity\Status;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class EditTacheType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('dateSupported', DateType::class)
        ->add('dateEnd', DateType::class)
        ->add('duration', TextType::class)
        ->add('image', FileType::class , array('data_class' => null) ,  ['constraints' => [
            new File([
                'mimeTypes' => [
                    'image/jpeg',
                    'image/png',
                    'image/webp'
                ],
            ])
        ]])
        ->add('description', TextareaType::class)
        ->add('status', EntityType::class, [
            'class'  => 'App:Status',
            'choice_label' => 'name',
            
        ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Repair::class,
        ]);
    }
}
