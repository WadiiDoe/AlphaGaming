<?php

namespace App\Form;

use App\Entity\Jeux;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\ResetType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class JeuxFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom',TextType::class,[
                'attr'=> [
                    'placeholder' =>'Nom',
                    'class'=> 'form-control'
                ]
            ])
            ->add('release_date',DateType::class,[
                'widget' => 'single_text',
                'attr' =>[
                    'class' => 'form-control',
                    'placeholder'=> 'dd/mm/yyyy',
                    'type'=>'date'
                ]
            ])

            ->add('prix',IntegerType::class,[
                'attr'=> [
                    'placeholder' => 'Prix',
                    'class' =>'form-control',
                    'type' => 'number',
                    'step'=>'any',
                    'empty_data'=> '0'
                ]
            ])
            ->add('qte_jeux',IntegerType::class,[
                'attr'=>[
                    'placeholder' => 'Quantité',
                    'class' =>'form-control',
                    'type' => 'number',
                    'empty_data'=> '0'
                ]
            ])
            ->add('description',TextareaType::class,[
                'attr'=>[
                    'placeholder' => 'Description',
                    'class' => 'form-control',
                    'required'=> false
                ]
            ])
            ->add('Img',FileType::class,array('data_class'=>null,'required' => false))
            ->add('submit',SubmitType::class,[
                'attr' => [
                    'class' => 'btn btn-primary mr-2'

                ]
            ])
            ->add('annuler',ResetType::class,[
                'attr' => [
                    'class' =>'btn btn-primary mr-2'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Jeux::class,
        ]);
    }
}
