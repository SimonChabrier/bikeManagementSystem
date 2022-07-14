<?php

namespace App\Form;

use App\Entity\Repair;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class RepairType extends AbstractType
{
    /**
     * Repair Form used on create and update a Repair
     * Note :'name' field is desabled on update using $options params
     * 
     * @param FormBuilderInterface $builder
     * @param array $options
     * @return void
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('reference', TextType::class, [
                'label' => 'Ajouter une référence à la réparation (facultatif)',
                'attr' => ([
                    'placeholder' => 'Eg : MaReférence'
                ]),
            ]) 
            ->add('name', TextType::class,[
                'label' => 'Saisir le nom de la Réparation',
                'disabled' => $options['edit_mode'],
                'attr' => ([
                    'placeholder' => 'Eg : Dérailleur'
                ]),
                'constraints' => [
                    new NotBlank([
                        'message' => 'Merci de saisir le nom de la réparation !',
                    ]),
                ],
            ]) 
            ->add('shortDescription', TextType::class, [
                'label' => 'Ajouter une description courte à la réparation (facultatif)',
                'attr' => ([
                    'placeholder' => 'Eg : Cette opréation consiste à ajuster le réglage du dérailleur'
                ]),
            ]) 
            ->add('longDescription', TextareaType::class, [
                'label' => 'Ajouter une description détaillée des étapes à réaliser (facultatif)',
                'attr' => ([
                    'placeholder' => 'Eg : Etape 1 : Mettre le vélo en sécurité sur le support de réparation... '
                ]),
            ]) 
            ->add('status', ChoiceType::class, [
                'label' => 'Statut de la Réparation',
                'choices'  => [
                    'Active' => true,
                    'Archive' => false,
                ],  
            ])
        ;
    }

    /**
     * Set method createForm() options values used in Controller sidel
     * on route app_repair_edit
     * @param OptionsResolver $resolver
     * @return void
     */
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Repair::class,
            'edit_mode' => false,
        ]);
    }
}
