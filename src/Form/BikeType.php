<?php

namespace App\Form;

use App\Entity\Bike;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;

class BikeType extends AbstractType
{
    /**
     * Bike Form used on create and update a Bike
     * Note :'number' field is desabled on update using $options params
     * 
     * @param FormBuilderInterface $builder
     * @param array $options
     * @return void
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder

            ->add('reference', TextType::class, [
                'label' => 'Ajouter une référence Agnélis au Vélo (facultatif)',
                'attr' => ([
                    'placeholder' => 'Eg : Ref-100'
                ]),
            ]) 
            ->add('number', NumberType::class, [
                'label' => 'Saisir le numéro identifiant Tempo du vélo',
                'disabled' => $options['edit_mode'],
                'attr' => ([
                    'placeholder' => 'Eg : 100'
                ]),
                'constraints' => [
                    new NotBlank([
                        'message' => 'Saisir le numéro Tempo le vélo !',
                    ]),
                ],
            ]) 
            ->add('availablity', ChoiceType::class, [
                'label' => 'Etat de disponibilité du vélo',
                'choices'  => [
                    'Choisir dans la liste' => null,
                    'Disponible' => 'Disponible',
                    'Bloqué pour maintenance' => 'Bloqué - Maintenance',
                    'En dépôt pour panne' => 'Dépôt - Panne',
                    'En dépôt pour stock' => 'Dépôt - Stock',
                    'Disparu' => 'Disparu',
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Choisir l\'état de disponibilité du vélo !',
                    ]),
                ],
            ]) 
            ->add('rate', ChoiceType::class, [
                'label' => 'Attribuer une note d\'état du vélo (facultatif)',
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

    /**
     * Set method createForm() options values used in Controller side
     * on route app_bike_edit
     * @param OptionsResolver $resolver
     * @return void
     */
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Bike::class,
            'edit_mode' => false,
        ]);
    }
}
