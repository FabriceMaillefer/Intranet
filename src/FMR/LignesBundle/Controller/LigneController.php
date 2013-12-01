<?php

namespace FMR\LignesBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use FMR\LignesBundle\Entity\Ligne;
use FMR\RelationClientBundle\Entity\RelationClientAvecLigne;
use FMR;

/**
 * Contrôleur de l'entité Ligne
 *
 * @author Fabrice Maillefer <fabrice.maillefer@gmail.com>
 * 
 * @Route("/ligne")
 */
class LigneController extends Controller
{
	private $path_class_ligne;
	private $path_template;
	private $path_repository;
	
	protected function getTemplate($template_action,$type){
		if ( $this->get('templating')->exists($this->path_template.$type.'\\'.$template_action.'.twig') ) {
			$template_path = $this->path_template.$type.'\\'.$template_action.'.twig';
	
		} else {
			$template_path = $this->path_template.$template_action.'.twig';
		}
		return $template_path;
	}
	
	public function __construct(){
		$this->path_class_ligne = 'FMR\LignesBundle\Entity\\';
		$this->path_template = 'FMRLignesBundle:Ligne:';
		$this->path_repository = 'FMRLignesBundle:';
		
	}
	
	/**
	 * Mise à jour de l'ordre des lignes
	 *
	 * @Route("/sortable", name="ligne_sort")
	 * @Method("POST")
	 */
	public function sortAction(Request $request){
		//verifie que la reqête est de l’AJAX
		if ($request->isXmlHttpRequest()){
			//récupération de l’entity manager
			$em = $this->getDoctrine()->getManager();
			//Explosion du tableau sérialisé de la requête en tableau PHP
			$sort = explode(",", $request->get('sort'));
			//Pour chaque élément du tableau : $index_ordre est l’index du tableau
			foreach ($sort as $index_ordre => $idLigne) {
				//Récupération de l’article depuis la base de données
				$ligne = $em->getRepository($this->path_repository.'Ligne')->find($idLigne);
				//Si l’article existe :
				if ($ligne) {
					//modifie l’ordre de l’article
					$ligne->setOrdre($index_ordre);
					//sauve l’entité
					$em->persist($ligne);
				}
			}
			//Execute les requêtes
			$em->flush();
			return new Response('Ordre ok');
		} else {
			return new Response('Seulement avec Ajax');
		}
		
	}
	
	/**
	 * Displays a form to edit an existing Facture entity.
	 *
	 * @Route("document/{id}/multiedit", name="relation_ligne_multiple_edit")
	 * @Method("GET")
	 */
	public function multipleEditAction(FMR\RelationClientBundle\Entity\Document\Document $entity)
	{
		//Controle que l'entité a un status qui permet la modification
		if (!$entity->isEditable()){
			$this->get('session')->getFlashBag()->add('error', 'Document vérouillé. Changez le statut pour pouvoir la modifier.');
			return $this->redirect($this->generateUrl('document_show', array('id' => $entity->getId())));
		}
	
		$type = $entity->getType();	
		return $this->render($this->path_template.'multipleEdit.html.twig',
				array(
						'entity'      => $entity,
				));
	}
    
    /**
     * Création d'une nouvelle ligne selon le _type donné
     *
     * @Route("/relation/{id}/", name="ligne_create")
     * @Method("POST")
     */
    public function createAction(Request $request,  RelationClientAvecLigne $relation)
    {
    	
    	$type=$request->request->get('_type');

    	if ($type==""){
    		throw new \Exception("Aucun type de ligne donné");
    	}
    	if (!is_subclass_of($this->path_class_ligne.$type, $this->path_class_ligne.'Ligne')) {
        	throw new \Exception("Type incompatible");
        }
        
    	//instanciation de l'entité spécifiée
    	$classe = $this->path_class_ligne . $type;
        $entity  = new $classe();
        
      
        $form = $this->createForm($entity->getForm(), $entity);
        $form->bind($request);
        
        $entity->setRelationClient($relation);
        
        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            
            $em->persist($entity);
            $em->flush();
            
			$this->get('session')->getFlashBag()->add('success', 'Cr&eacute;ation compl&egrave;te');
		
            return $this->redirect(
            		$this->generateUrl($relation->getRoute().'_show',
            		array('id' => $relation->getId()))
            	);
        }
		$this->get('session')->getFlashBag()->add('error', 'Erreur lors de la cr&eacute;ation');
		
        return $this->render($this->path_template.'new.html.twig',
        		array(
            'entity' => $entity,
            'form'   => $form->createView(),
        	'relationClient'=> $relation,
        	'type' => $type,
        ));
    }

    /**
     * Affichage d'un formulaire pour créer une ligne selon le type
     *
     * @Route("/relation/{id}/new/{type}", name="ligne_new")
     * 
     * @Method("GET")
     */
    public function newAction(Request $request, RelationClientAvecLigne $relation, $type="")
    {
    	if ($type==""){
    		throw new \Exception("Aucun type de ligne donné");
    	}
    	if (!is_subclass_of($this->path_class_ligne.$type, $this->path_class_ligne.'Ligne')) {
        	throw new \Exception("Type incompatible");
        }
        
    	//instanciation de l'entité spécifiée
    	$classe = $this->path_class_ligne . $type;
        $entity  = new $classe();
       
        
 		$entity->setRelationClient($relation);        
 		
        $form   = $this->createForm($entity->getForm(), $entity);

        $return_options = array(
            'entity' => $entity,
            'form'   => $form->createView(),
        	'relationClient'=> $relation,
        	'type' => $type,
        );
        
        //Si c'est une requête ajax : affichage du formulaire seul
		if ($request->isXmlHttpRequest()){
			return $this->render(
					$this->path_template.'new_single.html.twig',
					$return_options
			);
    	}
        return $this->render(
        		$this->path_template.'new.html.twig',
        		$return_options
        );
    }


    /**
     * Affichage d'un formulaire pour editer une ligne
     *
     * @Route("/{id}/edit", name="ligne_edit")
     * @Route("/{id}/edit/form", name="ligne_edit_form", defaults={"onlyForm"= "true"})
     * @Method("GET")
     */
    public function editAction(Request $request, Ligne $entity, $onlyForm=false)
    {
        $editForm = $this->createForm($entity->getForm(), $entity);

        
        $return_options = array(
        		'entity' => $entity,
        		'edit_form'   => $editForm->createView(),
        		'only_form' => $onlyForm,
        );

        if ($request->isXmlHttpRequest() || $onlyForm){
			return $this->render(
					$this->path_template.'edit_single.html.twig',
					$return_options
			);
    	}
        return $this->render(
        		$this->path_template.'edit.html.twig',
        		$return_options
        );
    }

    /**
     * Mise à jour d'une ligne
     *
     * @Route("/{id}", name="ligne_update")
     * @Method("PUT")
     */
    public function updateAction(Request $request, Ligne $entity)
    {
        $em = $this->getDoctrine()->getManager();
        
        $editForm = $this->createForm($entity->getForm(), $entity);
        $editForm->bind($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();
            
           
            if ($request->isXmlHttpRequest()){
            	return new Response('Modification r&eacute;ussie');
            }
            $this->get('session')->getFlashBag()->add('success', 'Modification r&eacute;ussie');
            return $this->redirect(
            		$this->generateUrl($entity->getRelationClient()->getRoute().'_show',
            		array('id' => $entity->getRelationClient()->getId())));
        }
        
        if ($request->isXmlHttpRequest()){
        	return new Response($this->getErrorMessagesToString($editForm),406);
        }
        
		$this->get('session')->getFlashBag()->add('error', 'Erreur lors de la modification');
        
        return $this->render(
			$this->path_template.'edit.html.twig',
			array(
				'entity'      => $entity,
				'edit_form'   => $editForm->createView(),
				'only_form' => false,
			)
        );
    }
    
    private function getErrorMessages(\Symfony\Component\Form\Form $form) {
    	$errors = array();
    
    	foreach ($form->getErrors() as $key => $error) {
    		$errors[] = $error->getMessage();
    	}
    
    	foreach ($form->all() as $child) {
    		if (!$child->isValid()) {
    			$errors[$child->getName()] = $this->getErrorMessages($child);
    		}
    	}
    	
    	return $errors;
    }
    private function getErrorMessagesToString(\Symfony\Component\Form\Form $form) {
    	$errors = $this->getErrorMessages($form);
    	$messages = '<ul>';
    	foreach ($errors as $champ => $error){
    		$messages.= '</ul>Champ : '.$champ.'<ul>';
    		foreach ($error as $message)
    			$messages.= '<li>'. $message .'</li>';
    	}
    	return $messages . "</ul>";
    }
    /**
     * Suppression d'une ligne
     *
     * @Route("/{id}/delete", name="ligne_delete")
     * @Method("GET")
     */
	public function deleteAction(Ligne $entity)
	{
		$em = $this->getDoctrine()->getManager();
		
		
		$em->remove($entity);
		$em->flush();
            
		$this->get('session')->getFlashBag()->add('success', 'Supression accomplie !');
		
		return $this->redirect($this->generateUrl($entity->getRelationClient()->getRoute().'_show', 
					array('id' => $entity->getRelationClient()->getId())));
		
	}
}
