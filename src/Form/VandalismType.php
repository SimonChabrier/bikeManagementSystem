<?php

namespace App\Form;

use App\Entity\Bike;
use App\Entity\Station;
use App\Entity\Vandalism;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Validator\Constraints\Image;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;


class VandalismType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder  
        
            ->add('bike', EntityType::class,[
                'class' => Bike::class,
                'label' => 'Selectionner le vélo dans la liste',
                'mapped' => true,
                'multiple' => false,
                'expanded' => false,
                'choice_label' => function ($bike) {
                    return $bike->getNumber();
                }
            ])
            ->add('station', EntityType::class, [
                'class' => Station::class,
                'mapped' => true,
                'label' => 'Selectionner la station dans la liste',
                'choice_label' => function ($station) {
                    return $station->getName();
                }
            ])
            ->add('content', TextareaType::class, [
                'label' => 'Description du vandalisme',
                'constraints' => [
                    new NotBlank([
                        'message' => 'Merci de saisir une description du vandalisme !',
                    ]),
                ],
            ]) 
            ->add('mainPicture', FileType::class, [
                'label' => 'Photo principale',
                'mapped' => false, 
                'constraints' => [
                    new Image([
                        'maxSize' => '5M'
                    ])
                ],
            ])
            ->add('status', ChoiceType::class, [
                'label' => 'Je confirme les informations',
                'multiple' => false,
                'expanded' => true,
                'choices'  => [
                    'Oui' => true,
                    'Non' => false,
                ],  
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Vandalism::class,
        ]);
    }
}
