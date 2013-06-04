<?php

namespace FMR\FactureBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use FMR\CommonBundle\Form\ArticleBaseType;

/**
 * Formulaire type pour un article de facture
 * @author Fabrice Maillefer
 */
class ArticleFactureType extends ArticleBaseType
{
	private $id;
	
	public function __construct($id = ""){
		$this->id = $id;
	}
	
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
       	parent::buildForm($builder, $options);
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'FMR\FactureBundle\Entity\ArticleFacture'
        ));
    }

    public function getName()
    {
        return 'fmr_facturebundle_articlefacturetype_'.$this->id;
    }
}
