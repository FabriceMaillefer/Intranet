<?php

namespace FMR\OffreBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use FMR\CommonBundle\Form\ArticleBaseType;

class ArticleOffreType extends ArticleBaseType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
       	parent::buildForm($builder, $options);
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'FMR\OffreBundle\Entity\ArticleOffre'
        ));
    }

    public function getName()
    {
        return 'fmr_offrebundle_articleoffretype';
    }
}
