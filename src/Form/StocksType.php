<?php

namespace App\Form;

use App\Entity\Stocks;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
class StocksType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('qte_prod',TextType::class,[
                                             'attr'=>[
                                                 'class'=>'form-control form-control-alternative'
                                             ]
                                         ])
            ->add('nom',TextareaType::class,[
                            'attr'=>[
                                'class'=>'form-control form-control-alternative'
                            ]
                        ])
            ->add('numerof',TextType::class,[
                            'attr'=>[
                                'class'=>'form-control form-control-alternative'
                            ]
                        ])
            ->add('prix_unitaire',TextType::class,[
                            'attr'=>[
                                'class'=>'form-control form-control-alternative'
                            ]
                        ])
            ->add('fournisseur')

            ->add('idprod',TextType::class,[
                                        'attr'=>[
                                            'class'=>'form-control form-control-alternative'
                                        ]
                                    ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Stocks::class,
        ]);
    }
}
