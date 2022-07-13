<?php

namespace App\Form;

use App\Entity\Station;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class StationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            
            ->add('reference', TextType::class, [
                'label' => 'Ajouter une référence à la Station (facultatif)',
                'attr' => ([
                    'placeholder' => 'Eg : MaReférence'
                ]),
            ]) 
            ->add('status', ChoiceType::class, [
                'label' => 'Statut de la Station',
                'choices'  => [
                    'Active' => true,
                    'Inactive' => false,
                ],
                
            ])
            ->add('name', TextType::class, [
                'label' => 'Saisir le nom de la Station',
                'attr' => ([
                    'placeholder' => 'Eg : Agen Gare'
                ]),
                'constraints' => [
                    new NotBlank([
                        'message' => 'Merci de saisir le nom de la Station !',
                    ]),
                ],
            ]) 
            ->add('address', TextType::class, [
                'label' => 'Saisir l\'adresse de la Station',
                'attr' => ([
                    'placeholder' => 'Eg : 1 Place Rabelais'
                ]),
                'constraints' => [
                    new NotBlank([
                        'message' => 'Merci de saisir \'adresse de la Station !',
                    ]),
                ],
            ]) 
            ->add('zip', NumberType::class, [
                'label' => 'Saisir le code postal de la Station',
                'attr' => ([
                    'placeholder' => 'Eg : 47000'
                ]),
                'constraints' => [
                    new NotBlank([
                        'message' => 'Merci de saisir le code postal de la Station !',
                    ]),
                ],
            ]) 
            ->add('city', ChoiceType::class, [
                'label' => 'Choisir la ville de la Station',
                'choices'  => [

                    'Agen' => "Agen",
                    'Bon Encontre' => "Bon Encontre",
                    'Le Passage' => "Le Passage",
                    'Pont Du Casse' => "Pont Du Casse",
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Merci de choisir la ville de la Station !',
                    ]),
                ],
            ])
            ->add('number', NumberType::class, [
                'label' => 'Saisir le numéro identifiant la Station',
                'attr' => ([
                    'placeholder' => 'Eg : 121'
                ]),
                'constraints' => [
                    new NotBlank([
                        'message' => 'Merci de saisir un numéro identifiant la Station !',
                    ]),
                ],
            ]) 
            //->add('lat')
            //->add('lng')
            //->add('slug')
            //->add('createdAt')
            //->add('updatedAt')
            // ->add('Enregister', SubmitType::class, [
            //     'attr' => ['class' => 'Enregistrer la Station'],
            // ]);
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Station::class,
        ]);
    }
}
