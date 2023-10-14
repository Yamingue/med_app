<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('username')
            ->add('nom')
            ->add('prenom')
            ->add('genre', ChoiceType::class, [
                'choices' => [
                    'MASCULIN' => 'M',
                    'FEMININ' => 'F',
                ]
            ])
            ->add('civilite', ChoiceType::class, [
                'choices' => [
                    'Professeur' => 'Pr',
                    'Docteur' => 'Dr',
                    'Monsieur' => 'Mr',
                    'Madame' => 'Mme',
                    'Mademoiselle' => 'Me',
                ],
                'attr' => [
                    'class' => 'select'
                ]
            ])
            ->add('roles', ChoiceType::class, options: [
                'multiple' => true,
                'choices' => [
                    'ADMINISTRATEUR' => 'ROLE_ADMIN',
                    'LABORATOIRE' => 'ROLE_LABORATOIRE',
                    'CONSULTATION' => 'ROLE_CONSULTATION',
                    'ACCUEILLE' => 'ROLE_USER',
                ],
                'attr' => [
                    'class' => 'select2'
                ]
            ])
            ->add('password', PasswordType::class, [
                'mapped' => false,
                'required'=> false,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
