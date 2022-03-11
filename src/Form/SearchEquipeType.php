<?php

namespace App\Form;

use App\Entity\Equipe;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SearchEquipeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom',TextType::class,[
                'required' => false,
                'label' => false,
                'attr' => [
                    'placeholder' => 'Nom'
                ]
            ])
            ->add('prenom',TextType::class,[
                'required' => false,
                'label' => false,
                'attr' => [
                    'placeholder' => 'Prenom'
                ]
            ])
            ->add('age',NumberType::class,[
                'required' => false,
                'label' => false,
                'attr' => [
                    'placeholder' => 'Age'
                ]
            ])
            ->add('metier',TextType::class,[
                'required' => false,
                'label' => false,
                'attr' => [
                    'placeholder' => 'Metier'
                ]
            ])
            ->add('search',SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Equipe::class,
            'method' => 'GET',
            'csrf_protection' => false
        ]);
    }

    public function getBlockPrefix(): string
    {
        return "";
    }
}
