<?php

namespace FMR\ChantierBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use FMR\ChantierBundle\Entity\Chantier;
use FMR\ChantierBundle\Form\ChantierType;
use FMR\OffreBundle\Entity\Offre;
use FMR\ClientBundle\Entity\Client;
use FMR\FactureBundle\Entity\Facture;
use FMR\FactureBundle\Entity\ArticleFacture;

/**
 * Chantier controller.
 *
 * @Route("/chantier")
 */
class ChantierController extends Controller
{
    /**
     * Lists all Chantier entities.
     *
     * @Route("/", name="chantier")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('FMRChantierBundle:Chantier')->findAll();

        return array(
            'entities' => $entities,
        );
    }

    /**
     * search and displays an Chantier entity.
     *
     * @Route("/search/", name="chantier_search")
     * @Template("FMRChantierBundle:Chantier:index.html.twig")
     */
    public function searchAction(Request $request)
    {
    
    	$q = $request->get('q');
    
    	$em = $this->getDoctrine()->getManager();
    
    	$qb = $em->createQueryBuilder();
    
    	$qb
    	->select('h')
    	->from('FMRChantierBundle:Chantier', 'h')
    	->innerJoin('h.client', 'c')
    	->where('CONCAT(c.nom, \' \', c.prenom) LIKE ?1')
    	->orWhere('CONCAT(c.prenom, \' \', c.nom) LIKE ?1')
    	->orWhere('h.description LIKE ?1')
    	->orWhere('h.architecte LIKE ?1')
    	->orWhere('h.lieu LIKE ?1')
    	->orWhere('h.id = ?2')
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
     * Creates a new Chantier entity.
     *
     * @Route("/", name="chantier_create")
     *
     * @Method("POST")
     * @Template("FMRChantierBundle:Chantier:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity  = new Chantier();
        $form = $this->createForm(new ChantierType(), $entity);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();
            
			$this->get('session')->getFlashBag()->add('success', 'Cr&eacute;ation compl&egrave;te');
		
            return $this->redirect($this->generateUrl('chantier_show', array('id' => $entity->getId())));
        }
		$this->get('session')->getFlashBag()->add('error', 'Erreur lors de la cr&eacute;ation');
        
        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }
    
    /**
     * Creates a new Facture entity for a Chantier.
     *
     * @Route("/{id}/facture", name="chantier_facture_create")
     * @Method("GET")
     */
    public function createFactureAction(Chantier $chantier)
    {
    	if ($chantier->getFacture()){
    		$this->get('session')->getFlashBag()->add('info', 'Facture déjà existante pour ce chantier!');
    		
    		return $this->redirect($this->generateUrl('facture_show', array('id' => $chantier->getFacture()->getId())));
    	}
    	$em = $this->getDoctrine()->getManager();
    	
    	$facture  = new Facture();
    	
    	//Création de la facture selon les données liée d'offre et du chantier
    	$facture->setChantier($chantier);
    	$facture->setClient($chantier->getClient());
    	if ($chantier->getOffre()){
    		$facture->setReferenceClient($chantier->getOffre()->getReferenceClient());
    	} else {
    		$facture->setReferenceClient($chantier->getDescription());
    	}
    	
    	$statut = $em->getRepository('FMRFactureBundle:StatutFacture')->find(1);
    	if ($statut) {
    		$facture->setStatut($statut);
    	}
    	
    	$ordre = 0;
    	//ajout des articles
    	foreach ($chantier->getFournitures() as $fourniture ){
    		$ordre++;
    		$article = new ArticleFacture();
    		$article
				->setFacture($facture)
    			->setOrdre($ordre)
    			->setDescriptif($fourniture->getLigneFacturation())
    			->setQuantite($fourniture->CalculQuantiteTotale())
    			->setUnite($fourniture->getUnite())
    		;
    		$em->persist($article);
    	}
    	
    	$chantier->setFacture($facture);
    	
    	$em->persist($facture);
    	$em->persist($chantier);
    	$em->flush();
    
    	$this->get('session')->getFlashBag()->add('success', 'Cr&eacute;ation de la facture compl&egrave;te avec '.$ordre.' articles importés.');
    
    	return $this->redirect($this->generateUrl('facture_article_multiple_edit', array('id' => $chantier->getFacture()->getId())));
    	
    	
    }

    /**
     * Displays a form to create a new Chantier entity.
     *
     * @Route("/new", name="chantier_new")
     * @Route("/offre/{id}/new", name="chantier_offre_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction(Offre $offre=null)
    {
        $entity = new Chantier();
        
        if ($offre){
        	$entity->setOffre($offre);
        	$entity->setClient($offre->getClient());
        	$entity->setDescription($offre->getReferenceClient());
        	$entity->setLieu($offre->getClient()->getLocalite());
        	
        	$em = $this->getDoctrine()->getManager();
        	
        	$statut = $em->getRepository('FMROffreBundle:StatutOffre')->find(3);
        	if ($statut) {
        		$offre->setStatut($statut);
        	}
      
        	$em->persist($offre);
        	$em->flush();
        }

        $form   = $this->createForm(new ChantierType(), $entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }
    /**
     * Displays a form to create a new Chantier entity from a Client Entity.

     * @Route("/client/{id}/new", name="chantier_client_new")
     * @Method("GET")
     * @Template("FMRChantierBundle:Chantier:new.html.twig")
     */
    public function newByClientAction(Client $client)
    {
    	$entity = new Chantier();

    	$entity->setClient($client);
    	$entity->setLieu($client->getLocalite());
    
    	$form   = $this->createForm(new ChantierType(), $entity);
    
    	return array(
    			'entity' => $entity,
    			'form'   => $form->createView(),
    	);
    }

    /**
     * Finds and displays a Chantier entity.
     *
     * @Route("/{id}", name="chantier_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('FMRChantierBundle:Chantier')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Chantier entity.');
        }

        return array(
            'entity'      => $entity,
        );
    }

    /**
     * Displays a form to edit an existing Chantier entity.
     *
     * @Route("/{id}/edit", name="chantier_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('FMRChantierBundle:Chantier')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Chantier entity.');
        }

        $editForm = $this->createForm(new ChantierType(), $entity);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
        );
    }

    /**
     * Edits an existing Chantier entity.
     *
     * @Route("/{id}", name="chantier_update")
     * @Method("PUT")
     * @Template("FMRChantierBundle:Chantier:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('FMRChantierBundle:Chantier')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Chantier entity.');
        }

        $editForm = $this->createForm(new ChantierType(), $entity);
        $editForm->bind($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();
            
            $this->get('session')->getFlashBag()->add('success', 'Modification r&eacute;ussie');

            return $this->redirect($this->generateUrl('chantier_edit', array('id' => $id)));
        }
        
		$this->get('session')->getFlashBag()->add('error', 'Erreur lors de la modification');
        
        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
        );
    }

    /**
     * Deletes a Chantier entity.
     *
     * @Route("/{id}/delete", name="chantier_delete")
     *@Method("GET")
     */
	public function deleteAction($id)
	{
		$em = $this->getDoctrine()->getManager();
		$entity = $em->getRepository('FMRChantierBundle:Chantier')->find($id);

		if (!$entity) {
			throw $this->createNotFoundException('Unable to find Chantier entity.');
		}
	
		
		$em->remove($entity);
		$em->flush();
            
		$this->get('session')->getFlashBag()->add('success', 'Supression accomplie !');

		return $this->redirect($this->generateUrl('chantier'));
	}
}
