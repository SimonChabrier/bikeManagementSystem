<?php

namespace App\Form;

use App\Entity\Bike;
use App\Entity\Balance;
use App\Entity\Station;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\ChoiceList\ChoiceList;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class BalanceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        
            ->add('bike', EntityType::class,[
                'class' => Bike::class,
                'label' => 'Selectionner le vélo à déplacer',
                'mapped' => true,
                'multiple' => false,
                'expanded' => false,
                'choice_label' => function ($bike) {
                    return $bike->getNumber();
                }
            ])
            ->add('stationPickUp', EntityType::class, [
                'class' => Station::class,
                'label' => 'Station d\'enlèvement',
                //'mapped' => true,
                'mapped' => false,
                'multiple' => false,
                'expanded' => false,
                'choice_label' => function ($station) {
                    return $station->getName();
                }
            ])
            ->add('stationDelivery', EntityType::class, [
                'class' => Station::class,
                'label' => 'Station de destination',
                //'mapped' => true,
                'mapped' => false,
                'multiple' => false,
                'expanded' => false,
                'choice_label' => function ($station) {
                    return $station->getName();
                }
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Balance::class,
        ]);
    }
}
