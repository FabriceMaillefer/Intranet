<?php

namespace FMR\ChantierBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class FournitureType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('date',null,array('label'=> 'Date', 'widget'=> 'single_text', 'attr'=>array('class'=>'input-medium')))
            ->add('descriptif',null,array('attr'=>array('class'=>'input-large')))
            ->add('quantite',null,array('label'=> 'Quantité','attr'=>array('class'=>'input-mini')))
            ->add('unite',null,array('label'=> 'Unité','attr'=>array('class'=>'input-medium')))

        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'FMR\ChantierBundle\Entity\Fourniture'
        ));
    }

    public function getName()
    {
        return 'fmr_chantierbundle_fournituretype';
    }
}
