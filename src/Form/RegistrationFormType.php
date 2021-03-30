<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\File\File;


class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom' , TextareaType::class,[
                'attr'=> [
                    'placeholder' => 'nom',
                    'class' =>'form-control',


                ]
            ])
            ->add('prenom', TextareaType::class,[
                'attr'=> [
                    'placeholder' => 'prenom',
                    'class' =>'form-control',


                ]
            ])
            ->add('adresse', TextareaType::class,[
                'attr'=> [
                    'placeholder' => 'adresse',
                    'class' =>'form-control',


                ]
            ])
            ->add('email' , TextareaType::class,[
                'attr'=> [
                    'placeholder' => 'email',
                    'class' =>'form-control',


                ]
            ])
            ->add('password' ,PasswordType::class,[
                'attr'=> [
                    'placeholder' => 'password',
                    'class' =>'form-control',


                ]
            ] )
            ->add('confirm_password' ,PasswordType::class ,[
                'attr'=> [
                    'placeholder' => 'confirm_password',
                    'class' =>'form-control',


                ]
            ] )
            ->add('imageFile',FileType::class )
            ->add('agreeTerms', CheckboxType::class, [
                'mapped' => false,
                'constraints' => [
                    new IsTrue([
                        'message' => 'You should agree to our terms.',
                    ]),
                ],
            ])




        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
