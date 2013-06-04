<?php

namespace FMR\FactureBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
/**
 * Formulaire type pour changer le statut d'une facture
 * @author Fabrice Maillefer
 */
class FactureChangeStatutType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('statut')
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
        return 'fmr_facturebundle_facturechangestatuttype';
    }
}
