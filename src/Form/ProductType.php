<?php

namespace App\Form;

use App\Entity\Product;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class ProductType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name',TextType::class,[
                'attr'=>[
                    'class'=>'form-control form-control-alternative'
                ]
            ])
            ->add('description',TextareaType::class,[
                'attr'=>[
                    'class'=>'form-control form-control-alternative'
                ]
            ])
            ->add('price',TextType::class,[
                'attr'=>[
                    'class'=>'form-control form-control-alternative'
                ]
            ])
            ->add('image',FileType::class,['mapped' => false,
                'attr' => array(
                    'accept' => 'image/jpeg,image/png',
                    'class'=>'form-control-file'
                ),

            ])
            ->add('category')
            ->add('Quantite')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Product::class,
        ]);
    }
}
