<?php

namespace FMR\CommonBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
/**
 * Contrôleur de la page d'accueil
 *
 * @author Fabrice Maillefer <fabrice.maillefer@gmail.com>
 */
class DefaultController extends Controller
{
    /**
     * Affichage des Offres, des Chantiers et des Factures actives
     * 
     * @Template()
     */
    public function indexAction()
    {
    	$em = $this->getDoctrine()->getManager();
    	
    	$offres  = $em->getRepository('FMRRelationClientBundle:Document\\Offre')->findAll();
    	$chantiers  = $em->getRepository('FMRChantierBundle:Chantier')->findAll();
    	$factures = $em->getRepository('FMRRelationClientBundle:Document\\Facture')->findAll();
    	
    	return array(
    			'offres' =>  $offres,
    			'chantiers' => $chantiers,
    			'factures' => $factures,
    	);    }
}
