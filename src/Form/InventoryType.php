<?php

namespace App\Form;

use App\Entity\Bike;
use App\Entity\Station;
use App\Entity\Inventory;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class InventoryType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        
            ->add('station', EntityType::class, [
                'class' => Station::class,
                'label' => 'Selectionner la station',
                'choice_label' => function ($station) {
                    return $station->getName();
                }
            ])
            ->add('bikes', EntityType::class,[
                'class' => Bike::class,
                'label' => 'Selectionner les vélos présents sur la station',
                'mapped' => true,
                'multiple' => true,
                'expanded' => true,
                'choice_label' => function ($bike) {
                    return $bike->getNumber();
                }
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Inventory::class,
        ]);
    }
}
