<?php

namespace App\Form;

use App\Entity\Plannings;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PlanningsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('unite')
            ->add('date')
            ->add('planning',CollectionType::class, [
                'entry-type'=>PlanningType::class,
                'entry_option'=>['label' => false],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Plannings::class,
        ]);
    }
}
