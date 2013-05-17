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
            ->add('descriptif')
            ->add('quantite')
            ->add('unite')
            ->add('prixUnitaire')
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
