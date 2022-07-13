<?php

namespace App\Form\Temp;

use App\Entity\Station;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class OldStationTourType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
             ->add('name', TextType::class, [
                'label' => 'Station',
                'disabled' => true,
            ]) 
            ->add('number', ChoiceType::class, [
                'label' => 'Définir l\'ordre de la staion sur la tournée',
                'choices'  => [
                    '1' => '1',
                    '2' => '2',
                    '3' => '3',
                    '4' => '4',
                    '5' => '5',
                    '6' => '6',
                    '7' => '7',
                    '8' => '8',
                    '9' => '9',
                    '10' => '10',
                    '11' => '11',
                    '12' => '12',
                    '13' => '13',
                    '14' => '14',
                    '15' => '15',
                    '16' => '16',
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Merci choisir un numéro pour la station sélectionnée !',
                    ]),
                ],
            ]) 
            ->add('Enregister', SubmitType::class, [
                'attr' => ['class' => 'Enregistrer la Station'],
            ]);
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Station::class,
        ]);
    }
}
