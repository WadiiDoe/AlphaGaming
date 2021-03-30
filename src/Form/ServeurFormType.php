<?php

namespace App\Form;

use App\Entity\Jeux;
use App\Entity\Serveur;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ResetType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ServeurFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('adr_sv',TextType::class,[
                'attr'=>[
                    'placeholder'=>'Adresse',
                    'class'=>'form-control',
                    'type'=>'text'
                ]
            ])
            ->add('description_sv',TextareaType::class,[
                'attr'=>[
                    'placeholder'=> 'Description',
                    'class'=> 'form-control',
                    'rows'=> 5
                ]
            ])
            ->add('nom_sv',TextType::class,[
                'attr'=>[
                    'placeholder'=> 'Nom ',
                    'class'=> 'form-control',
                    'type'=>'text'
                ]
            ])
            ->add('jeux',EntityType::class,[
                'class'=>Jeux::class,
                'choice_label'=>'nom',
                'attr'=>[
                    'class'=>'btn btn-outline-warning dropdown-toggle',
                ]
            ])

            ->add('submit',SubmitType::class,[
                'attr'=>[
                    'class'=>'btn btn-primary mr-2'
                ]
            ])
            ->add('Annuler',ResetType::class,[
                'attr'=>[
                    'class'=>'btn btn-dark'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Serveur::class,
        ]);
    }
}
