<?php

namespace App\Form;

use App\Entity\Reclamation;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ReclamationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('description',TextType::class,[
                'attr'=>[
                    'class'=>'form-control form-control-alternative'
                ]
            ])

            ->add('nom',TextType::class,[
                'attr'=>[
                    'class'=>'form-control form-control-alternative'
                ]
            ])
            ->add('email',TextType::class,[
                'attr'=>[
                    'class'=>'form-control form-control-alternative'
                ]
            ])         ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Reclamation::class,
        ]);
    }
}
