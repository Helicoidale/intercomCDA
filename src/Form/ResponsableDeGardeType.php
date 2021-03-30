<?php

namespace App\Form;

use App\Entity\ResponsableDeGarde;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ResponsableDeGardeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom')
            //->add('uniteSoin')
            ->add('telConsultation')
            ->add('telDomicile')
            ->add('telPortable')
            //->add('idUniteSoin')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => ResponsableDeGarde::class,
        ]);
    }


}
