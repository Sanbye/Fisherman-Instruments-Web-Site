<?php

namespace App\Form;

use App\Entity\Instrument;
use App\Entity\Section;
use SebastianBergmann\CodeCoverage\Report\Text;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ButtonType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class SectionFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('titre',TextType::class,[
                'label' => 'Titre (optionnel) :'
                ])
            ->add('image', FileType::class, [
                'label' => 'Uploader une image(optionnel, uniquement format jpg, png et webp) :',
                'mapped' => false,
                'required' => false,
                'constraints' => [
                    new File([
                        'maxSize' => '4096k',
                        'mimeTypes' => [
                            'image/png',
                            'image/jpeg',
                            'image/webp',
                        ],
                        'mimeTypesMessage' => 'Veuillez sélectionner une image au bon format (uniquement format jpg, png et webp)',
                    ])
                ],
            ])
            ->add('text',TextareaType::class,[
                'label'=>'Entrez ici votre text:',
                'attr' => ['rows' =>'10', 'cols' =>'80'],
                'required'=>'true',
                'trim' => 'false'
            ])
            ->add('position', IntegerType::class, [
                'label' => "Position dans la page : "
            ])

            ->add('instrument', EntityType::class,[
                'label'=>'Si vous souhaitez afficher un instrument, sélectionnez le ici, sinon vous pouvez ignorer ceci',
                'class' => Instrument::class,
                'choice_label' => 'nom',
                'placeholder' => 'Choisir un instrument',
                'mapped' => false,
                'required' => false
            ])

            ->add('valider', SubmitType::class, [
                'attr' => ['class' => 'button']])
            ->add('annuler', ButtonType::class, [
                'attr' => ['class' => 'button','onclick'=> 'annulerNewSection()']])
        ;

    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Section::class,
        ]);
    }
}
