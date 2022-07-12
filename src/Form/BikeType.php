<?php

namespace App\Form;

use App\Entity\Bike;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class BikeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder

            ->add('reference', TextType::class, [
                'label' => 'Facultatif - Saisir votre référence pour le vélo',
                'attr' => ([
                    'placeholder' => 'Eg : Ref-100'
                ]),
            ]) 
            ->add('number', TextType::class, [
                'label' => 'Saisir le numéro identifiant Tempo du vélo',
                'attr' => ([
                    'placeholder' => 'Eg : 100'
                ]),
                'constraints' => [
                    new NotBlank([
                        'message' => 'Saisir le numéro Tempo le vélo !',
                    ]),
                ],
            ]) 
            ->add('rate', ChoiceType::class, [
                'label' => 'Facultatif - Attribuer une note d\'état du vélo',
                'choices'  => [
                    'Attribuer une note d\'état du vélo' => null,
                    '1' => '1',
                    '2' => '2',
                    '3' => '3',
                    '4' => '4',
                    '5' => '5',
                    '6' => '6',
                    '7' => '7',
                    '8' => '8',
                    '9' => '9',
                    '10' => '10'
                ],
            ]) 
            ->add('status', ChoiceType::class, [
                'label' => 'Statut du vélo',
                'choices'  => [
                    'Visible' => true,
                    'Archivé' => false,
                ],
                
            ])
            //->add('lat')
            //->add('lng')
            //->add('purchasedAt')
            //->add('slug')
            //->add('createdAt')
            //->add('updatedAt')
            //->add('mainPicture')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Bike::class,
        ]);
    }
}
