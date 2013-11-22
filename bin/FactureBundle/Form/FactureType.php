<?php

namespace FMR\FactureBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Formulaire type pour une facture
 * @author Fabrice Maillefer
 */
class FactureType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('referenceClient',null,array('required'=> false,'label'=>'Référence pour le client'))
            ->add('rabais')
            ->add('tVA')
            ->add('client')
            ->add('chantier')
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'FMR\FactureBundle\Entity\Facture'
        ));
    }

    public function getName()
    {
        return 'fmr_facturebundle_facturetype';
    }
}
