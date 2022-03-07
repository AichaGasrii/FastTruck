<?php

namespace App\Form;

use App\Entity\Livreurs;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class LivreursType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom',TextareaType::class,[
                'attr'=>[
                    'class'=>'form-control form-control-alternative'
                ]
            ])
            ->add('prenom',TextareaType::class,[
                'attr'=>[
                    'class'=>'form-control form-control-alternative'
                ]
            ])


            ->add('tel',TextareaType::class,[
                'attr'=>[
                    'class'=>'form-control form-control-alternative'
                ]
            ])
            ->add('email',TextareaType::class,[
                'attr'=>[
                    'class'=>'form-control form-control-alternative'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Livreurs::class,
        ]);
    }
}