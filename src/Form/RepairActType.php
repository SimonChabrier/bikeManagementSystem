<?php

namespace App\Form;

use App\Entity\Station;
use App\Entity\Repair;
use App\Entity\Bike;
use App\Entity\RepairAct;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RepairActType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('station', EntityType::class,[
            'class' => Station::class,
            'label' => 'Selectionner la station',
            'mapped' => true,
            'multiple' => false,
            'expanded' => false,
            'choice_label' => function ($station) {
                return $station->getName();
            }
        ])
        ->add('bike', EntityType::class,[
            'class' => Bike::class,
            'label' => 'Selectionner le vélo',
            'mapped' => true,
            'multiple' => false,
            'expanded' => false,
            'choice_label' => function ($bike) {
                return $bike->getNumber();
            }
        ])
        ->add('repair', EntityType::class, [
            'class' => Repair::class,
            'label' => 'Selectionner la réparation',
            'choice_label' => function ($repair) {
                return $repair->getName();
            }
        ])
     
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => RepairAct::class,
        ]);
    }
}
