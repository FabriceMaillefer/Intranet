<?php

namespace FMR\RelationClientBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
/**
 * Formulaire type pour un document
 * @author Fabrice Maillefer
 */
class DocumentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('referenceClient',null,array('required'=> false,'label'=>'Référence pour le client'))
            ->add('rabais','percent')
            ->add('tva','percent')
            ->add('client')
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(	
            'data_class' => 'FMR\RelationClientBundle\Entity\Document\Document'
        ));
    }

    public function getName()
    {
        return 'fmr_offrebundle_offretype';
    }
}
