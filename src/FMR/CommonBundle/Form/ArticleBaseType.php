<?php

namespace FMR\CommonBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ArticleBaseType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('descriptif',null,array('attr'=>array('class'=>'input-large')))
            ->add('quantite',null,array('label'=> 'Quantité','attr'=>array('class'=>'input-mini')))
            ->add('unite',null,array('label'=> 'Unité','attr'=>array('class'=>'input-medium')))
            ->add('prixUnitaire',null,array('label'=> 'Prix Unitaire','attr'=>array('class'=>'input-mini')))
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'FMR\CommonBundle\Entity\ArticleBase'
        ));
    }

    public function getName()
    {
        return 'fmr_commonbundle_articlebasetype';
    }
}
