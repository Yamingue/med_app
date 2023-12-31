<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserPassType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('old_pass', PasswordType::class,[
                'label'=>'Ancien mot de passe'
            ])
            ->add('new_pass', RepeatedType::class,[
                'type'=> PasswordType::class,
                'first_options'=>[
                    'label'=>'Nouveau mot de passe'
                ],
                'second_options'=>[
                    'label'=>'Repeter mot de passe'
                ]
            ])
            ->add('Modifier', SubmitType::class)
            ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
