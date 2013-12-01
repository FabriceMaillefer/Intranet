<?php

namespace FMR\RelationClientBundle\Form;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Formulaire type pour changer le statut d'une offre
 * @author Fabrice Maillefer
 */
class DocumentChangeStatutType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('statut',null,array('attr'=>array('class'=>'input-sm'),'horizontal_input_wrapper_class'=>'col-sm-10','label_attr'=>array('class'=>'col-sm-2')))
            
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
        return 'fmr_offrebundle_offrechangestatuttype';
    }
}
