<?php

namespace App\Form;

use App\Entity\ProviderDevice;
use App\Repository\UsersRepository;
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
        ->add('users', EntityType::class, [
            'class' => 'App:Users',
            //fait une requete pour afficher que les ROLE_SERVICE_PROVIDER dans le select, "u" est un allias de "users"
            'query_builder' => function (UsersRepository $usersRepository) {
                return $usersRepository->createQueryBuilder('u')
                    ->where("u.role = 'ROLE_SERVICE_PROVIDER'");
            },
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
