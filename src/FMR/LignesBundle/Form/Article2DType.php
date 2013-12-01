<?php

namespace FMR\LignesBundle\Form;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Formulaire type pour une fourniture 2D
 * @author Fabrice Maillefer
 */
class Article2DType extends Article1DType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);
        $builder
            ->add('largeur',null,array('attr'=>array('class'=>'input-sm'), 'widget_form_group_attr' => array('class'=>'col-md-3 col-sm-3 control-group')))
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'FMR\LignesBundle\Entity\Article2D'
        ));
    }
}
