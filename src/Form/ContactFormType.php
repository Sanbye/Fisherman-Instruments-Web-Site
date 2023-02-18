<?php

namespace App\Form;

use App\Entity\Info;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ContactFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom', TextType::class,[
                'label' => 'Nom :',
                'attr' => ['placeholder' => 'Nom :']
            ])
            ->add('prenom', TextType::class,[
                'label' => 'Prenom :',
                'attr' => ['placeholder' => 'Prenom :']
            ])
            ->add('telephone', TelType::class,[
                'label' => 'Votre numéro de téléphone :',
                'attr' => ['placeholder' => 'Téléphone :']
            ])
            ->add('mail', EmailType::class,[
                'label' => 'Votre adresse mail :',
                'attr' => ['placeholder' => 'Mail :']
            ])
            ->add('text',TextareaType::class,[
                'label' => 'Votre message...',
                'attr' => ['rows' =>'4', 'cols' => '80',
                    'placeholder' => 'Votre message...'],
                'required'=> true,
            ])
            ->add('valider', SubmitType::class, [
                'attr' => ['class' => 'button']])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Info::class,
        ]);
    }
}
