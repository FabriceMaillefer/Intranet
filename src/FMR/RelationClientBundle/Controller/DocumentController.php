<?php

namespace FMR\RelationClientBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use FMR\ClientBundle\Entity\Client;
use FMR\RelationClientBundle\Entity\Document;
use Ps\PdfBundle\Annotation\Pdf;
use FMR\RelationClientBundle\Form\DocumentChangeStatutType;

/**
 * Contrôleur de l'entité Document
 *
 * @author Fabrice Maillefer <fabrice.maillefer@gmail.com>
 *
 * @Route("/document")
 */
class DocumentController extends Controller
{
	
	private $path_class_ligne;
	private $path_template;
	private $path_repository;
	
	public function __construct(){
		$this->path_class_ligne = 'FMR\RelationClientBundle\Entity\Document\\';
		$this->path_template = 'FMRRelationClientBundle:Document:';
		$this->path_repository = 'FMRRelationClientBundle:Document\\';
	}
	
	protected function getTemplate($template_action,$type){
		if ( $this->get('templating')->exists($this->path_template.$type.'\\'.$template_action.'.twig') ) {
			$template_path = $this->path_template.$type.'\\'.$template_action.'.twig';
			 
		} else {
			$template_path = $this->path_template.'Document'.'\\'.$template_action.'.twig';
		}
		return $template_path;
	}
	
    /**
     * Lists all Facture entities.
     *
     * @Route("/{type}", name="document")
     * @Route("/facture", name="facture", defaults={"type"= "Facture"})
     * @Route("/offre", name="offre", defaults={"type"= "Offre"})
     * @Route("/commande", name="commande", defaults={"type"= "Commande"})
     * 
     * @Method("GET")
     */
    public function indexAction($type="")
    {
    	if ($type==""){
    		throw new \Exception("Aucun type de document donné");
    	}
    	if (!is_subclass_of($this->path_class_ligne.$type, $this->path_class_ligne.'Document')) {
        	throw new \Exception("Type incompatible");
        }
    	
        //instanciation de l'entité spécifiée
        $classe = $this->path_class_ligne . $type;
        $entity  = new $classe();
    	
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository($this->path_repository.$type)->findAll();

		return $this->render($this->getTemplate('index.html',$type),    	
			array(
				'entities' => $entities,
				'entity' => $entity
			));
    }
    
    

    /**
     * search and displays an Facture entity.
     *
     * @Route("/{type}/search/", name="document_search")
     */
    public function searchAction(Request $request, $type="")
    {
    	
    	$q = $request->get('q');
    
    	$em = $this->getDoctrine()->getManager();
    
    	$entities = null;
    
    	if ($type==""){
    		throw new \Exception("Aucun type de document donné");
    	}
    	if (!is_subclass_of($this->path_class_ligne.$type, $this->path_class_ligne.'Document')) {
    		throw new \Exception("Type incompatible");
    	}
    	 
    	//instanciation de l'entité spécifiée
    	$classe = $this->path_class_ligne . $type;
    	$entity  = new $classe();
    	
		return $this->render($this->getTemplate('index.html',$type),    			
			array(
    			'entities' => $entities,
    			'recherche' => $q,
				'entity' => $entity
    	));
    }
    

    /**
     * Finds and displays a Facture entity.
     *
     * @Route("/{id}/show", name="document_show")
     * @Method("GET")
     *
     */
    public function showAction(Document\Document $entity)
    {
    	$formStatut = $this->createForm(new DocumentChangeStatutType(), $entity);
    	$type = $entity->getType();
    
    	return $this->render($this->getTemplate('show.html', $type),
    			array(
    					'entity'      => $entity,
    					'formStatut' => $formStatut->createView(),
    			));
    }
    
    

    /**
     * Displays a form to create a new Facture entity.
     *
     * @Route("/{type}/new", name="document_new")
     * @Route("/{type}/client/{id}/new", name="document_client_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction(Client $client=null, $type="")
    {
       if ($type==""){
    		throw new \Exception("Aucun type de document donné");
    	}
    	if (!is_subclass_of($this->path_class_ligne.$type, $this->path_class_ligne.'Document')) {
        	throw new \Exception("Type incompatible");
        }
        
    	//instanciation de l'entité spécifiée
    	$classe = $this->path_class_ligne . $type;
        $entity  = new $classe();
        
        if(!is_null($client)) $entity->setClient($client);
        
        $form   = $this->createForm($entity->getForm(), $entity);
        
        
        return $this->render($this->getTemplate('new.html',$type),
        		array(
        				'entity' => $entity,
        				'form'   => $form->createView(),
        		));
    }
  
    /**
     * Creates a new Facture entity.
     *
     * @Route("/", name="document_create")
     * @Method("POST")
     */
    public function createAction(Request $request)
    {
    	$type=$request->request->get('_type');
    
    	if ($type==""){
    		throw new \Exception("Aucun type de document donné");
    	}
    	if (!is_subclass_of($this->path_class_ligne.$type, $this->path_class_ligne.'Document')) {
    		throw new \Exception("Type incompatible");
    	}
    
    	//instanciation de l'entité spécifiée
    	$classe = $this->path_class_ligne . $type;
    	$entity  = new $classe();
    
    	$form = $this->createForm($entity->getForm(), $entity);
    	$form->bind($request);
    
    	if ($form->isValid()) {
    		$em = $this->getDoctrine()->getManager();
    
    		$statut = $em->getRepository('FMRRelationClientBundle:StatutDocument')->find(1);
    		if ($statut) {
    			$entity->setStatut($statut);
    		}
    
    		$em->persist($entity);
    		$em->flush();
    
    		$this->get('session')->getFlashBag()->add('success', 'Cr&eacute;ation compl&egrave;te');
    
    		return $this->redirect($this->generateUrl('document_show', array('id' => $entity->getId())));
    	}
    	$this->get('session')->getFlashBag()->add('error', 'Erreur lors de la cr&eacute;ation');
    
    	return $this->render($this->getTemplate('new.html',$type),
    			array(
    					'entity' => $entity,
    					'form'   => $form->createView(),
    					 
    			));
    }
    

    /**
     * Displays a form to edit an existing Facture entity.
     *
     * @Route("/{id}/edit", name="document_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction(Document\Document $entity)
    {
		//Controle que l'entité a un status qui permet la modification
        if (!$entity->isEditable()){
        	$this->get('session')->getFlashBag()->add('error', 'Document vérouillé. Changez le statut pour pouvoir la modifier.');
        	return $this->redirect($this->generateUrl('document_show', array('id' => $entity->getId())));
        }

        $type = $entity->getType();
        $editForm = $this->createForm($entity->getForm(), $entity);

		return $this->render($this->getTemplate('edit.html',$type),
			array(            
				'entity'      => $entity,
            	'edit_form'   => $editForm->createView(),
        ));
    }

    /**
     * Edits an existing Facture entity.
     *
     * @Route("/{id}", name="document_update")
     * @Method("PUT")
     */
    public function updateAction(Request $request, Document\Document $entity)
    {
        $em = $this->getDoctrine()->getManager();

        $editForm = $this->createForm($entity->getForm(), $entity);
        $editForm->bind($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();
            
            $this->get('session')->getFlashBag()->add('success', 'Modification r&eacute;ussie');

            return $this->redirect($this->generateUrl('document_show', array('id' => $entity->getId())));
        }
        
		$this->get('session')->getFlashBag()->add('error', 'Erreur lors de la modification');
		$type = $entity->getType();
		
        return $this->render($this->getTemplate('edit.html',$type),
        	array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
        	));
    }

    /**
     * Deletes a Facture entity.
     *
     * @Route("/{id}/delete", name="document_delete")
     * @Method("GET")
     */
	public function deleteAction(Document\Document $entity)
	{
		$em = $this->getDoctrine()->getManager();

		$em->remove($entity);
		$em->flush();
            
		$this->get('session')->getFlashBag()->add('success', 'Supression accomplie !');

		return $this->redirect($this->generateUrl('document',array('type'=>$entity->getType())));
	}
	
	
	/**
	 * Formattage de la facture en PDF ou en HTML selon le format
	 *
	 * @Route("/print/{id}", name="document_print", defaults={"_format"="html"})
	 * @Method("GET")
	 *
	 * @Pdf(stylesheet="::print-style.xml.twig")
	 */
	public function printAction(Document\Document $entity)
	{
		$format = $this->get('request')->get('_format');
	
		$em = $this->getDoctrine()->getManager();
		 
		if (!$entity->getDateImpression() || $this->get('request')->get('_force')) {
			//Mise à jour de la date d'impression de la facture
			$dateImpression = new \DateTime();
			$entity->setDateImpression($dateImpression);
			//Changement du statut de la facture
		    $statut = $em->getRepository('FMRRelationClientBundle:StatutDocument')->find(2);
    		if ($statut) {
    			$entity->setStatut($statut);
    			if ($entity->isEditable()){
    				throw new \Exception("Status du document ne permet pas d'imprimer. statut 2");
    			}
    		}
			$em->persist($entity);
			$em->flush();
		}
		$type = $entity->getType();
		
		return $this->render($this->getTemplate("print.".$format,$type),
				array(
						'entity'      => $entity,
				));
	}
	
	
	/**
	 * Permet de changer le statut de la facture
	 *
	 * @Route("/{id}/statut", name="facture_statut")
	 * @Method("PUT")
	 */
	public function changeStatutAction(Request $request, Document\Document $facture)
	{
		$em = $this->getDoctrine()->getManager();
	
	
		$formStatut = $this->createForm(new DocumentChangeStatutType(), $facture);
	
		$formStatut->bind($request);
	
		if ($formStatut->isValid()) {
			$em->persist($facture);
			$em->flush();
	
			$this->get('session')->getFlashBag()->add('success', 'Modification du statut r&eacute;ussie');
	
			return $this->redirect($this->generateUrl('document_show', array('id' => $facture->getId())));
		}
	
		$this->get('session')->getFlashBag()->add('error', 'Erreur lors de la modification du statut');
	
		return $this->render($this->getTemplate('show.html', $type),
    	array(
    			'entity'      => $facture,
				'formStatut' => $formStatut->createView(),
		));
	}
	
	
	
}
