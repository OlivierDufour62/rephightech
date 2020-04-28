<?php

namespace App\Form;

use App\Entity\Repstatus;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RepStatusType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder
            ->add('comment', TextareaType::class)
            ->add('status', EntityType::class, [
                'class'  => 'App:Status',
                'choice_label' => 'name',
            ]);

        $builder->addEventListener(FormEvents::class, function(FormEvent $event){
            $form = $event->getForm();
            $form->add('ServiceProvider', EntityType::class, [
                'class'  => 'App:ServiceProvider',
                'choice_label' => 'name',
                'require' => false
            ]);
        });
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Repstatus::class,
        ]);
    }
}
