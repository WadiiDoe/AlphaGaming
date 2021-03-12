<?php

namespace App\Form;

use App\Entity\Jeux;
use mysql_xdevapi\Result;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RateFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder

            ->add('rating',TextType::class,[
                'required'=>false,
                'attr'=>[
                    'class'=>'form-control',
                    'id'=>'result',
                    'value'=>'text'
                ]
            ])




            ->add('Evaluez',SubmitType::class,[
                'attr'=>[
                    'id'=>'btn_rate',
                    'class'=>'nk-btn nk-btn-rounded nk-btn-color-dark-3 float-right',
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
