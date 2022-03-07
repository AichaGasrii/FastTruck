<?php

namespace App\Form;

use App\Entity\Fournisseur;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
class FournisseurType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
->add('nom',TextareaType::class,[
                            'attr'=>[
                                'class'=>'form-control form-control-alternative'
                            ]
                        ])
->add('numero',TextareaType::class,[
                            'attr'=>[
                                'class'=>'form-control form-control-alternative'
                            ]
                        ])
->add('designation',TextareaType::class,[



                            'attr'=>[
                                'class'=>'form-control form-control-alternative'
                            ]
                        ])
->add('statu',TextareaType::class,[
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
            'data_class' => Fournisseur::class,
        ]);
    }
}
