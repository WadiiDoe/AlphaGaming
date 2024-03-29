<?php

namespace App\Form;

use App\Entity\Article;
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

class ArticleFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('titre_article',TextType::class,[
                'attr'=>[
                    'class'=>'form-control',
                    'placeholder'=> 'Titre',
                    'required'=> true
                ]
            ])
            ->add('contenu_article',TextareaType::class,[
                'attr'=>[
                    'placeholder'=> 'Ecrire quelque chose',
                    'class'=>'form-control',
                    'required'=> true
                ]
            ])
            ->add('img_article',FileType::class,array('data_class'=>null,'required' => false))

            ->add('date_article',DateType::class,[
                'widget'=>'single_text',
                'attr'=>[
                    'type'=>'date',
                    'placeholder'=>'dd/mm/yyyy',
                    'class'=> 'form-control'

                ]
            ])
            ->add('nbr_article',IntegerType::class,[
                'attr'=>[
                    'type'=>'number',
                    'class'=>'form-control',
                    'placeholder'=>'--',
                    'required'=> true
                ]
            ])
            ->add('submit', SubmitType::class,[
                'attr'=>[
                    'class'=>'btn btn-success btn-rounded btn-fw'
                ]

            ])
            ->add('annuler',ResetType::class,[
                'attr'=>[
                    'class'=>'btn btn-danger btn-rounded btn-fw'
                ]
            ])


        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Article::class,
        ]);
    }
}
