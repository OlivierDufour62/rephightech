<?php

namespace App\Form;

use App\Entity\Employee;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('lastname', TextType::class)
            ->add('firstname', TextType::class)
            ->add('phonenumber', TextType::class)
            ->add('email', TextType::class)
            ->add('password', PasswordType::class)
            ->add('genre', ChoiceType::class ,['expanded'=>true,'choices' => [
                'Monsieur' => true,
                'Madame' => false
            ]])
            ->add('role', ChoiceType::class, [
                'choices' => [
                        'Utilisateur' => 'ROLE_USER',
                        'Admin' => 'ROLE_ADMIN',
            ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Employee::class,
        ]);
    }
}
