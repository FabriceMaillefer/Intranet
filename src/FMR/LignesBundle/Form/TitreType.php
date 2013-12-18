<?php

namespace FMR\LignesBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Formulaire type pour un article de base
 * @author Fabrice Maillefer
 */
class TitreType extends AbstractType
{
	private $nom_unique;
	
	public function __construct($nom_unique=''){
		$this->nom_unique = $nom_unique;
	}
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
           ->add('titre',null,array('attr'=>array('class'=>'input-sm'), 'widget_form_group_attr' => array('class'=>'col-sm-12')))
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'FMR\LignesBundle\Entity\Titre'
        ));
    }

    public function getName()
    {
        return 'fmr_lignesbundle_titretype_'.$this->nom_unique;
    }
}
