<?php

namespace FMR\ChantierBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class Fourniture3DType extends Fourniture2DType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
    	parent::buildForm($builder, $options);
        $builder
            ->add('hauteur',null,array('attr'=>array('class'=>'input-small')))
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'FMR\ChantierBundle\Entity\Fourniture3D'
        ));
    }

    public function getName()
    {
        return 'fmr_chantierbundle_fourniture3dtype';
    }
}
