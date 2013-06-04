<?php

namespace FMR\FactureBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Formulaire type pour éditer tout les articles d'une facture d'un seul coup
 * @author Fabrice Maillefer
 */
class FactureMultipleArticleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('referenceClient',null,array('required'=> false,'label'=>'Référence pour le client'))
	    	->add('rabais')
	    		->add('articles', 'collection', 
	    				array(
	    				'type'   => new ArticleFactureType()
	    		)
	    	)
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
        return 'fmr_facturebundle_facturemultiplearticletype';
    }
}
