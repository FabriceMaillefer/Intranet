<?php

namespace FMR\ChantierBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class Fourniture2DType extends Fourniture1DType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);
        $builder
            ->add('largeur',null,array('attr'=>array('class'=>'input-small')))
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'FMR\ChantierBundle\Entity\Fourniture2D'
        ));
    }

    public function getName()
    {
        return 'fmr_chantierbundle_fourniture2dtype';
    }
}
