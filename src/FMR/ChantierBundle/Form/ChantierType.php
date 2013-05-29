<?php

namespace FMR\ChantierBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ChantierType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('architecte',null,array('required'=> false))
            ->add('lieu',null,array('required'=> false))
            ->add('description',null,array('required'=> false))
            ->add('dateDebut',null,array('required'=> false))
            ->add('dateFin',null,array('required'=> false))
            ->add('client',null,array('required'=> false))
            ->add('offre',null,array('required'=> false))
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'FMR\ChantierBundle\Entity\Chantier'
        ));
    }

    public function getName()
    {
        return 'fmr_chantierbundle_chantiertype';
    }
}
