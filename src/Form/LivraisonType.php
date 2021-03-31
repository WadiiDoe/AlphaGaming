<?php

namespace App\Form;
use App\Entity\Client;
use App\Entity\Livraieur;
use App\Entity\Livraison;
use App\Entity\Produit;
use Captcha\Bundle\CaptchaBundle\Form\Type\CaptchaType;
use Captcha\Bundle\CaptchaBundle\Validator\Constraints\ValidCaptcha;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class LivraisonType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('numl')
            ->add('livraieur',EntityType::class,array('class' => Livraieur::class,'choice_label' => 'Nom' ))
            ->add('client',EntityType::class,array('class' => Client::class,'choice_label' => 'Nom' ))
            ->add('adrliv',EntityType::class,array('class' => Client::class,'choice_label' => 'adrLiv' ))
            ->add('dateliv',DateType::class,['label' => 'Date livraison:   : ','widget' => 'single_text'])
            ->add('produit',EntityType::class,array('class' => Produit::class,'choice_label' => 'nom' ))
            ->add('total')
            ->add('captchaCode', CaptchaType::class, array(
                'captchaConfig' => 'ExampleCaptchaUserRegistration',
                'constraints' => [
                    new ValidCaptcha([
                        'message' => 'Invalid captcha, please try again',
                    ]),
                ],
            ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Livraison::class,
        ]);
    }

}
