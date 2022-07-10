<?php

namespace App\Form;

use App\Entity\Station;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class StationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            
            ->add('reference', TextType::class, [
                'label' => 'Saisir la référence de la Station (facultatif)',
            ]) 
            ->add('name', TextType::class, [
                'label' => 'Saisir le nom de la Station',
                'constraints' => [
                    new NotBlank([
                        'message' => 'Merci de saisir le nom de la Station !',
                    ]),
                ],
            ]) 
            ->add('address', TextType::class, [
                'label' => 'Saisir l\'adresse de la Stationde la Station',
                'constraints' => [
                    new NotBlank([
                        'message' => 'Merci de saisir \'adresse de la Stationde la Station !',
                    ]),
                ],
            ]) 
            ->add('zip', TextType::class, [
                'label' => 'Saisir le code postal de la Station',
                'constraints' => [
                    new NotBlank([
                        'message' => 'Merci de saisir le code postal de la Station !',
                    ]),
                ],
            ]) 
            ->add('city', TextType::class, [
                'label' => 'Saisir la ville de la Station',
                'constraints' => [
                    new NotBlank([
                        'message' => 'Merci de saisir la ville de la Station !',
                    ]),
                ],
            ]) 
            //->add('status')
            //->add('tourOrder')
            //->add('lat')
            //->add('lng')
            //->add('slug')
            //->add('createdAt')
            //->add('updatedAt')
            ->add('save', SubmitType::class, [
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
