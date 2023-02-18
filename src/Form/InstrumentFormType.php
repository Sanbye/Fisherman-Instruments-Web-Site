<?php

namespace App\Form;

use App\Entity\Instrument;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class InstrumentFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('images', FileType::class, [
                'label' => 'Uploader des images(uniquement format jpg, png et webp) : ',
                'mapped' => false,
                'required' => false,
                'multiple' => true,
                'constraints' => [
                    new File([
                        'maxSize' => '1024k',
                        'mimeTypes' => [
                            'image/png',
                            'image/jpeg',
                            'image/webp',
                        ],
                        'mimeTypesMessage' => 'Veuillez sélectionner une image au bon format (uniquement format jpg, png et webp)',
                    ])
                ],
            ])
            ->add('nom', TextType::class, [
                'label' => "Nom de l'instrument : "
                ])
            ->add('prix', IntegerType::class, [
                'label' => "Prix : ",
                'required' => false,
            ])
            ->add('preview', FileType::class, [
                'label' => 'Uploader image de preview (uniquement format jpg, png et webp) :',
                'mapped' => false,
                'required' => true,
                'constraints' => [
                    new File([
                        'maxSize' => '1024k',
                        'mimeTypes' => [
                            'image/png',
                            'image/jpeg',
                            'image/webp',
                        ],
                        'mimeTypesMessage' => 'Veuillez sélectionner une image au bon format (uniquement format jpg, png et webp)',
                    ])
                ],
            ])
            ->add('description',TextareaType::class, [
                'label' => "Description de l'instrument : ",
                'attr' => ['rows' =>'10', 'cols' =>'200'],
                'required'=>true,
                'trim' => 'false'
            ])

            ->add('position', IntegerType::class, [
                'label' => "Position dans la page : "
            ])
            ->add('valider', SubmitType::class, [
                'attr' => ['class' => 'button']])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Instrument::class,
        ]);
    }
}
