<?php

namespace App\Form;

use App\Entity\Station;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class StationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            
            ->add('reference', TextType::class, [
                'label' => 'Saisir la référence de la Station (facultatif)',
                'attr' => array(
                    'placeholder' => 'Eg : gare'
                ),
            ]) 
            ->add('status', ChoiceType::class, [
                'label' => 'Statut de la station',
                'choices'  => [
                    'Active' => true,
                    'Inactive' => false,
                ],
                
            ])
            ->add('name', TextType::class, [
                'label' => 'Saisir le nom de la Station',
                'attr' => array(
                    'placeholder' => 'Eg : Agen Gare'
                ),
                'constraints' => [
                    new NotBlank([
                        'message' => 'Merci de saisir le nom de la Station !',
                    ]),
                ],
            ]) 
            ->add('address', TextType::class, [
                'label' => 'Saisir l\'adresse de la Stationde la Station',
                'attr' => array(
                    'placeholder' => 'Eg : 1 Place Rabelais'
                ),
                'constraints' => [
                    new NotBlank([
                        'message' => 'Merci de saisir \'adresse de la Stationde la Station !',
                    ]),
                ],
            ]) 
            ->add('zip', TextType::class, [
                'label' => 'Saisir le code postal de la Station',
                'attr' => array(
                    'placeholder' => 'Eg : 47000'
                ),
                'constraints' => [
                    new NotBlank([
                        'message' => 'Merci de saisir le code postal de la Station !',
                    ]),
                ],
            ]) 
            ->add('city', TextType::class, [
                'label' => 'Saisir la ville de la Station',
                'attr' => array(
                    'placeholder' => 'Eg : Agen'
                ),
                'constraints' => [
                    new NotBlank([
                        'message' => 'Merci de saisir la ville de la Station !',
                    ]),
                ],
            ]) 
            ->add('tourOrder', ChoiceType::class, [
                'label' => 'Ordre de la station sur la tournée',
                'choices'  => [
                    'Voir la liste' => null,
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
                        'message' => 'Merci de saisir la ville de la Station !',
                    ]),
                ],
            ]) 
            //->add('lat')
            //->add('lng')
            //->add('slug')
            //->add('createdAt')
            //->add('updatedAt')
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
