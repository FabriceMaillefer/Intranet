<?php

namespace FMR\ClientBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use FMR\ClientBundle\Entity\Client;
use FMR\ClientBundle\Form\ClientType;


/**
 * Contrôleur de l'entité client.
 * 
 * @Route("/client")
 * @author Fabrice Maillefer <fabrice.maillefer@gmail.com>
 */
class ClientController extends Controller
{
    /**
     * Liste des clients créé récement
     *
     * @Route("/", name="client")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('FMRClientBundle:Client')->findRecents();

        return array(
            'entities' => $entities,
        );
    }

    /**
     * Recherche et affichage les clients trouvés
     *
     * @Route("/search/", name="client_search")
     * @Template("FMRClientBundle:Client:index.html.twig")
     */
    public function searchAction(Request $request)
    {
    	
    	$q = $request->get('q');
    	
    	$em = $this->getDoctrine()->getManager();
    
    	$entities = $em->getRepository('FMRClientBundle:Client')->search($q);
    	$count = count($entities);
    	
    	return array(
    			'entities' => $entities,
    			'recherche' => $q,
    			'count' => $count,
    	);
    }
    
    /**
     * Création d'un nouveau Client
     *
     * @Route("/", name="client_create")
     * @Method("POST")
     * @Template("FMRClientBundle:Client:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity  = new Client();
        $form = $this->createForm(new ClientType(), $entity);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();
            
			$this->get('session')->getFlashBag()->add('success', 'Cr&eacute;ation compl&egrave;te');
		
            return $this->redirect($this->generateUrl('client_show', array('id' => $entity->getId())));
        }
		$this->get('session')->getFlashBag()->add('error', 'Erreur lors de la cr&eacute;ation');
        
        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Affichage du formulaire pour créer un nouveau client
     *
     * @Route("/new", name="client_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Client();
        $form   = $this->createForm(new ClientType(), $entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Trouve et affiche un client
     * Affiche aussi ses offres, chantiers et factures en cours
     *
     * @Route("/{id}", name="client_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction(Client $entity)
    {
        $em = $this->getDoctrine()->getManager();

        $offres  = $em->getRepository('FMROffreBundle:Offre')->findAllActiveForClient($entity);

        $chantiers  = $em->getRepository('FMRChantierBundle:Chantier')->findAllActiveForClient($entity);     
        
        $factures = $em->getRepository('FMRFactureBundle:Facture')->findAllActiveForClient($entity);
        
        return array(
            'entity'      => $entity,
        	'offres' =>  $offres,
        	'chantiers' => $chantiers,
        	'factures' => $factures,
        );
    }

    /**
     * Affichage du formulaire pour modifier un client
     *
     * @Route("/{id}/edit", name="client_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction(Client $entity)
    {
        $editForm = $this->createForm(new ClientType(), $entity);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
        );
    }

    /**
     * Mise à jour du client
     *
     * @Route("/{id}", name="client_update")
     * @Method("PUT")
     * @Template("FMRClientBundle:Client:edit.html.twig")
     */
    public function updateAction(Request $request, Client $entity)
    {
        $em = $this->getDoctrine()->getManager();

        $editForm = $this->createForm(new ClientType(), $entity);
        $editForm->bind($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();
            
            $this->get('session')->getFlashBag()->add('success', 'Modification r&eacute;ussie');

            return $this->redirect($this->generateUrl('client_show', array('id' => $id)));
        }
        
		$this->get('session')->getFlashBag()->add('error', 'Erreur lors de la modification');
        
        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
        );
    }

    /**
     * Suppression d'un client
     *
     * @Route("/{id}/delete", name="client_delete")
     * @Method("GET")
     */
    public function deleteAction(Client $entity)
    {
    	$em = $this->getDoctrine()->getManager();
    	 
		$em->remove($entity);
		$em->flush();
		
		$this->get('session')->getFlashBag()->add('success', 'Supression accomplie !');

        return $this->redirect($this->generateUrl('client'));
    }
}
