<?php

namespace FMR\LignesBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Formulaire type pour un article de base
 * @author Fabrice Maillefer
 */
class ArticleType extends AbstractType
{
	private $nom_unique;
	
	public function __construct($nom_unique=''){
		$this->nom_unique = $nom_unique;
	}
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('date','date',array('label'=> 'Date','datepicker' => true, 'widget'=> 'single_text', 'attr'=>array('class'=>'input-sm'), 'widget_form_group_attr' => array('class'=>'col-lg-2 col-md-3 col-sm-3')))
           ->add('descriptif',null,array('attr'=>array('class'=>'input-sm'), 'widget_form_group_attr' => array('class'=>'col-sm-3')))
            ->add('quantite',null,array('label'=> 'Quantité','attr'=>array('class'=>'input-sm'), 'widget_form_group_attr' => array('class'=>'col-md-2 col-sm-2')))
            ->add('unite',null,array('label'=> 'Unité','attr'=>array('class'=>'input-sm'), 'widget_form_group_attr' => array('class'=>'col-md-2 col-sm-2')))
            ->add('prixUnitaire','money',array('currency'=>'chf','label'=> 'Prix Unitaire','attr'=>array('class'=>'input-sm'), 'widget_form_group_attr' => array('class'=>'col-md-3 col-sm-3')))
            
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'FMR\LignesBundle\Entity\Article'
        ));
    }

    public function getName()
    {
        return 'fmr_lignebundle_articletype_'.$this->nom_unique;
    }
}
