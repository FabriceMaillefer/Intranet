<?php

namespace FMR\ChantierBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Formulaire type pour une fourniture 1D
 * @author Fabrice Maillefer
 */
class Fourniture1DType extends FournitureType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);
        $builder
            ->add('longueur',null,array('attr'=>array('class'=>'input-small')))
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'FMR\ChantierBundle\Entity\Fourniture1D'
        ));
    }

    public function getName()
    {
        return 'fmr_chantierbundle_fourniture1dtype';
    }
}
