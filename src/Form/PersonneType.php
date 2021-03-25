<?php

namespace App\Form;

use App\Entity\Personne;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\EventListener\TrimListener;
use Symfony\Component\Form\Extension\Csrf\EventListener\CsrfValidationListener;

class PersonneType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom')
            ->add('prenom')
            ->add('mail')
            ->add('fonction')
            ->add('secteur',EntityType::class, [
                'class'         =>'App\Entity\Secteur',
                'placeholder'   => 'Selectionnez le secteur',
                'required'      =>false,
                'mapped'        =>false


           ]);
       /* dump("je suis la" );
        $builder ->get('secteur')->addEventListener(

            FormEvents::POST_SUBMIT,

            function (FormEvent $event){
                dump($event->getForm());
                dump($event->getData());
                dump("je suis la" );
                $form=$event->getForm();
               // $builder=$form->getConfig()->getFormFactory()->createNamedBuilder(

              //  )
               dump($form->getData());
               // $this->addServiceField($form->getParent(),$form->getData());
               $form->getParent()->add('services',EntityType::class ,[
                'class'         =>'App\Entity\Service',
                'placeholder'   => 'selectionnez le service',
                'mapped'        =>true,
                'required'      =>false,
                'auto_initialize'=>false,
                'choices'       =>$form->getData()->getServices()
                    ]);

            }
        );*/


    }

    /**
     * Rajoute un champ service au formulaire
     * @param FormInterface $form
     * @param Secteur $secteur
     */
private function AddServiceField( FormInterface $form ,Secteur $secteur){

        $builder = $form->getConfig()->getFormFactory()->createNamedBuilder(
            'service',
            EntityType::class,
            null,
            [
                'class'         =>'App\Entity\Service',
                'placeholder'   =>$secteur ? 'selectionnez le service':'selectionnez le secteur',
                'mapped'        =>false,
                'auto_initialize'=>false,
                'choices'       =>$form->getData()->getServices()
            ]
        );

        /*
        $builder->addEventListener(
            FormEvents::POST_SUBMIT,
            function (FormEvent $event){
                $form=$event->getForm();
                $this->add
            }
        )
        */
    $form->add($builder->getForm());
}









    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Personne::class,
        ]);
    }
}
