<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;



class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', EmailType::class,[
                'label' => 'Saisir votre Email',
                'constraints' => [
                    new NotBlank([
                        'message' => 'Merci de saisir une adresse mail valide !',
                    ]),
                ],
            ])
            ->add('plainPassword', PasswordType::class, [
                'label' => 'Saisir votre mot de passe',
                // instead of being set onto the object directly,
                // this is read and encoded in the controller
                'mapped' => false,
                'attr' => ['autocomplete' => 'new-password'],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Merci de saisir un mot de passe !',
                    ]),
                    new Length([
                        'min' => 4,
                        'minMessage' => 'Le mot de passe doit comporter au inimum {{ limit }} caractères',
                        // max length allowed by Symfony for security reasons
                        'max' => 4096,
                    ]),
                ],
            ])
            ->add('company', ChoiceType::class, [
                'label' => 'Choisir votre entreprise dans la liste',
                'choices'  => [
                    'Voir la liste' => null,
                    'Agnelis' => 'agnelis',
                    'Esat' => 'esat',
                ],

                'constraints' => [
                    new NotBlank([
                        'message' => 'Vous devez choisir votre entreprise dans la liste !',
                    ]),
                ],
            ])
            ->add('job', ChoiceType::class, [
                'label' => 'Choisir votre fonction dans la liste',
                'choices'  => [
                    'Voir la liste' => null,
                    'Administrateur' => 'administrateur',
                    'Moniteur' => 'moniteur',
                    'Partenaire' => 'partenaire',
                    'Travailleur' => 'travailleur',
                ],

                'constraints' => [
                    new NotBlank([
                        'message' => 'Vous devez choisir votre fonction dans la liste !',
                    ]),
                ],
            ])
            ->add('firstName', TextType::class, [
                'label' => 'Saisir votre prénom - Actuel identifiant sur l\'appli',
                'constraints' => [
                    new NotBlank([
                        'message' => 'Merci de saisir votre prénom !',
                    ]),
                ],
            ]) 
            ->add('lastName', TextType::class, [
                'label' => 'Saisir votre nom',
                'constraints' => [
                    new NotBlank([
                        'message' => 'Merci de saisir votre nom !',
                    ]),
                ],
            ])  
            ->add('address', TextType::class, [
                'label' => 'Saisir votre adresse postale',
                'constraints' => [
                    new NotBlank([
                        'message' => 'Merci de saisir votre adresse postale !',
                    ]),
                ],
            ])  
            ->add('zip', TextType::class, [
                'label' => 'Saisir votre code postal',
                'constraints' => [
                    new NotBlank([
                        'message' => 'Merci de saisir votre code postal !',
                    ]),
                ],
            ]) 
            ->add('city', TextType::class, [
                'label' => 'Saisir votre ville',
                'constraints' => [
                    new NotBlank([
                        'message' => 'Merci de saisir votre ville !',
                    ]),
                ],
            ]) 
            ->add('phone', TextType::class, [
                'label' => 'Saisir votre numéro de téléphone',
                'constraints' => [
                    new NotBlank([
                        'message' => 'Merci de saisir votre numéro de téléphone !',
                    ]),
                ],
            ])   
            ->add('Conditions', CheckboxType::class, [
                'mapped' => false,
                'constraints' => [
                    new IsTrue([
                        'message' => 'Vous devez accepter les conditions d\'utilisation.',
                    ]),
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
