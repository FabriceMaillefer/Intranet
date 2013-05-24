<?php

namespace FMR\OffreBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use FMR\OffreBundle\Entity\Offre;
use FMR\ClientBundle\Entity\Client;
use FMR\OffreBundle\Form\OffreType;
use FMR\OffreBundle\Form\OffreChangeStatutType;

/**
 * Offre controller.
 *
 * @Route("/offre")
 */
class OffreController extends Controller
{
    /**
     * Lists all Offre entities.
     *
     * @Route("/", name="offre")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('FMROffreBundle:Offre')->findAll();

        return array(
            'entities' => $entities,
        );
    }

    /**
     * search and displays an Offre entity.
     *
     * @Route("/search/", name="offre_search")
     * @Template("FMROffreBundle:Offre:index.html.twig")
     */
    public function searchAction(Request $request)
    {
    	 
    	$q = $request->get('q');
    	 
    	$em = $this->getDoctrine()->getManager();
    
    	$qb = $em->createQueryBuilder();
    	 
    	$qb
    	->select('o')
    	->from('FMROffreBundle:Offre', 'o')
    	->innerJoin('o.client', 'c')
    	->where('CONCAT(c.nom, \' \', c.prenom) LIKE ?1')
    	->orWhere('CONCAT(c.prenom, \' \', c.nom) LIKE ?1')
    	->orWhere('o.referenceClient LIKE ?1')
    	->orWhere('o.id = ?2')
    	->setParameter('1','%'.$q.'%')
    	->setParameter('2',$q)
    	
    	;
    	 
    	 
    	$query = $qb->getQuery();
    	$entities = $query->getResult();
    	 
    	return array(
    			'entities' => $entities,
    			'recherche' => $q,
    	);
    }
    
    
    /**
     * Creates a new Offre entity.
     *
     * @Route("/", name="offre_create")
     * @Method("POST")
     * @Template("FMROffreBundle:Offre:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity  = new Offre();
        
        $form = $this->createForm(new OffreType(), $entity);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $statut = $em->getRepository('FMROffreBundle:StatutOffre')->find(1);
            if ($statut) {
            	$entity->setStatut($statut);
            }
            
            $em->persist($entity);
            $em->flush();
            
			$this->get('session')->getFlashBag()->add('success', 'Cr&eacute;ation compl&egrave;te');
		
            return $this->redirect($this->generateUrl('offre_show', array('id' => $entity->getId())));
        }
		$this->get('session')->getFlashBag()->add('error', 'Erreur lors de la cr&eacute;ation');
        
        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Displays a form to create a new Offre entity.
     *
     * @Route("/new", name="offre_new")
     * @Route("/client/{id}/new", name="offre_client_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction(Client $client=null)
    {
        $entity = new Offre();
        $entity->setClient($client);
        
        $form   = $this->createForm(new OffreType(), $entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        	'client' => $client,
        );
    }

    /**
     * Finds and displays a Offre entity.
     *
     * @Route("/{id}", name="offre_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('FMROffreBundle:Offre')->find($id);
		
        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Offre entity.');
        }

        $formStatut = $this->createForm(new OffreChangeStatutType(), $entity);
        
        return array(
            'entity'      => $entity,
        	'formStatut' => $formStatut->createView(),
        );
    }
    
    /**
     * Permet de changer le statut de l'offre
     *
     * @Route("/{id}/statut", name="offre_statut")
     * @Method("PUT")
     * @Template("FMROffreBundle:Offre:show.html.twig")
     */
    public function changeStatutAction(Request $request, Offre $offre)
    {
    	$em = $this->getDoctrine()->getManager();
    
    	$formStatut = $this->createForm(new OffreChangeStatutType(), $offre);

    	$formStatut->bind($request);
    
    	if ($formStatut->isValid()) {
    		$em->persist($offre);
    		$em->flush();
    
    		$this->get('session')->getFlashBag()->add('success', 'Modification du statut r&eacute;ussie');
    
    		return $this->redirect($this->generateUrl('offre_show', array('id' => $offre->getId())));
    	}
    
    	$this->get('session')->getFlashBag()->add('error', 'Erreur lors de la modification du statut');
    
    	return array(
    			'entity'      => $entity,
    			'formStatut' => $formStatut->createView(),
    	);
    }

    /**
     * Displays a form to edit an existing Offre entity.
     *
     * @Route("/{id}/edit", name="offre_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('FMROffreBundle:Offre')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Offre entity.');
        }

        if (!$entity->isEditable()){
        	$this->get('session')->getFlashBag()->add('error', 'Offre vérouillée. Changez le statut pour pouvoir la modifier.');
        	return $this->redirect($this->generateUrl('offre_show', array('id' => $id)));
        }
        
        $editForm = $this->createForm(new OffreType(), $entity);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
        );
    }

    /**
     * Edits an existing Offre entity.
     *
     * @Route("/{id}", name="offre_update")
     * @Method("PUT")
     * @Template("FMROffreBundle:Offre:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('FMROffreBundle:Offre')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Offre entity.');
        }

        $editForm = $this->createForm(new OffreType(), $entity);
        $editForm->bind($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();
            
            $this->get('session')->getFlashBag()->add('success', 'Modification r&eacute;ussie');

            return $this->redirect($this->generateUrl('offre_show', array('id' => $id)));
        }
        
		$this->get('session')->getFlashBag()->add('error', 'Erreur lors de la modification');
        
        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
        );
    }

    /**
     * Deletes a Offre entity.
     *
     * @Route("/{id}/delete", name="offre_delete")
     *@Method("GET")
     */
	public function deleteAction($id)
	{
		$em = $this->getDoctrine()->getManager();
		$entity = $em->getRepository('FMROffreBundle:Offre')->find($id);

		if (!$entity) {
			throw $this->createNotFoundException('Unable to find Offre entity.');
		}
		
		$em->remove($entity);
		$em->flush();
            
		$this->get('session')->getFlashBag()->add('success', 'Supression accomplie !');

		return $this->redirect($this->generateUrl('offre'));
	}
}
