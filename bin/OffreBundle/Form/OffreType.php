<?php

namespace FMR\OffreBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
/**
 * Formulaire type pour une offre
 * @author Fabrice Maillefer
 */
class OffreType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('referenceClient',null,array('required'=> false,'label'=>'Référence pour le client'))
            ->add('client')
            ->add('tVA')
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'FMR\OffreBundle\Entity\Offre'
        ));
    }

    public function getName()
    {
        return 'fmr_offrebundle_offretype';
    }
}
