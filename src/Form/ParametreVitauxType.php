<?php

namespace App\Form;

use App\Entity\ParametreViteaux;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ParametreVitauxType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('temperature', options:[
                'label'=>'Temperature (°C)'
            ])
            ->add('poids',options:[
                'label'=>'Poids (Kg)'
            ])
            ->add('tails',options:[
                'label'=>'Tails (cm)'
            ])
            ->add('tension_arterielle')
            ->add('Enregistrer', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ParametreViteaux::class,
        ]);
    }
}
