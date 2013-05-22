<?php

namespace FMR\ClientBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ClientType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom')
            ->add('prenom',null,array('label' => 'Prénom'))
            ->add('adresse',null,array('required'=> false))
            ->add('nPA',null,array('label' => 'NPA','required'=> false))
            ->add('localite',null,array('label' => 'Localité'))
            ->add('email','email',array('required'=> false))
            ->add('divers','textarea',array('required'=> false))
           
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'FMR\ClientBundle\Entity\Client'
        ));
    }

    public function getName()
    {
        return 'fmr_clientbundle_clienttype';
    }
}