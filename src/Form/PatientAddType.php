<?php

namespace App\Form;

use App\Entity\Patient;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PatientAddType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom')
            ->add('prenom')
            ->add('telephone')
            ->add('ne_le', DateType::class,[
                'widget' => 'single_text',
                'html5' => false,
                'attr' => ['placeholder' => 'JJ-MM-AAAA'],
                'format' => 'dd-MM-yyyy',
            ])
            ->add('Ajouter', SubmitType::class,[
                'attr'=>[
                    'class'=>'w-100 btn-primary'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Patient::class,
        ]);
    }
}
