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
 * Contrôleur de l'entité Chantier
 *
 * @author Fabrice Maillefer
 *
 * @Route("/chantier")
 */
class ChantierController extends Controller
{
    /**
     * Liste des chantiers actifs
     *
     * @Route("/", name="chantier")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('FMRChantierBundle:Chantier')->findAllActive();

        return array(
            'entities' => $entities,
        );
    }

    /**
     * Recherche et affichage des chantiers trouvés
     *
     * @Route("/search/", name="chantier_search")
     * @Template("FMRChantierBundle:Chantier:index.html.twig")
     */
    public function searchAction(Request $request)
    {
    	$q = $request->get('q');
    
    	$em = $this->getDoctrine()->getManager();
    
    	$entities = $em->getRepository('FMRChantierBundle:Chantier')->search($q);
    
    	return array(
    			'entities' => $entities,
    			'recherche' => $q,
    	);
    }
    
    /**
     * Création d'un nouveau Chantier
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
     * Création d'une nouvelle Facture à partir d'un Chantier 
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
    	
    	//Parametrage du status "En création"
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
     * Affichage du formulaire pour créer un nouveau Chantier
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
     * Affiche un formulaire pour créer un nouveau Chantier à partir d'un Client
     * 
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
     * Trouve et affiche un Chantier
     *
     * @Route("/{id}", name="chantier_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction(Chantier $entity)
    {
        return array(
            'entity'      => $entity,
        );
    }

    /**
     * Affichage du formulaire pour modifier un Chantier
     *
     * @Route("/{id}/edit", name="chantier_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction(Chantier $entity)
    {

        $editForm = $this->createForm(new ChantierType(), $entity);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
        );
    }

    /**
     * Mise à jour du Chantier
     *
     * @Route("/{id}", name="chantier_update")
     * @Method("PUT")
     * @Template("FMRChantierBundle:Chantier:edit.html.twig")
     */
    public function updateAction(Request $request, Chantier $entity)
    {
        $em = $this->getDoctrine()->getManager();
        
        $editForm = $this->createForm(new ChantierType(), $entity);
        $editForm->bind($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();
            
            $this->get('session')->getFlashBag()->add('success', 'Modification r&eacute;ussie');

            return $this->redirect($this->generateUrl('chantier_show', array('id' => $id)));
        }
        
		$this->get('session')->getFlashBag()->add('error', 'Erreur lors de la modification');
        
        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
        );
    }

    /**
     * Suppression d'un Chanteir
     *
     * @Route("/{id}/delete", name="chantier_delete")
     * @Method("GET")
     */
	public function deleteAction(Chantier $entity)
	{
		$em = $this->getDoctrine()->getManager();
		
		$em->remove($entity);
		$em->flush();
            
		$this->get('session')->getFlashBag()->add('success', 'Supression accomplie !');

		return $this->redirect($this->generateUrl('chantier'));
	}
}
