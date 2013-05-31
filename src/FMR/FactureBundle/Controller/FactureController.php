<?php

namespace FMR\FactureBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use FMR\FactureBundle\Entity\Facture;
use FMR\ClientBundle\Entity\Client;
use FMR\FactureBundle\Form\FactureType;
use FMR\FactureBundle\Form\ArticleFactureType;
use FMR\FactureBundle\Form\FactureChangeStatutType;
use FMR\FactureBundle\Form\FactureMultipleArticleType;
use Ps\PdfBundle\Annotation\Pdf;

/**
 * Facture controller.
 *
 * @Route("/facture")
 */
class FactureController extends Controller
{
    /**
     * Lists all Facture entities.
     *
     * @Route("/", name="facture")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('FMRFactureBundle:Facture')->findRecents();

        return array(
            'entities' => $entities,
        );
    }
    
    

    /**
     * search and displays an Facture entity.
     *
     * @Route("/search/", name="facture_search")
     * @Template("FMRFactureBundle:Facture:index.html.twig")
     */
    public function searchAction(Request $request)
    {
    
    	$q = $request->get('q');
    
    	$em = $this->getDoctrine()->getManager();
    
    	$entities = $em->getRepository('FMRFactureBundle:Facture')->search($q);
    
    	return array(
    			'entities' => $entities,
    			'recherche' => $q,
    	);
    }
    
    
    /**
     * Creates a new Facture entity.
     *
     * @Route("/", name="facture_create")
     * @Method("POST")
     * @Template("FMRFactureBundle:Facture:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity  = new Facture();
        $form = $this->createForm(new FactureType(), $entity);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            
            $statut = $em->getRepository('FMRFactureBundle:StatutFacture')->find(1);
            if ($statut) {
            	$entity->setStatut($statut);
            }
            
            $em->persist($entity);
            $em->flush();
            
			$this->get('session')->getFlashBag()->add('success', 'Cr&eacute;ation compl&egrave;te');
		
            return $this->redirect($this->generateUrl('facture_show', array('id' => $entity->getId())));
        }
		$this->get('session')->getFlashBag()->add('error', 'Erreur lors de la cr&eacute;ation');
        
        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Displays a form to create a new Facture entity.
     *
     * @Route("/new", name="facture_new")
     * @Route("/client/{id}/new", name="facture_client_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction(Client $client=null)
    {
        $entity = new Facture();
        
        $entity->setClient($client);
        
        $form   = $this->createForm(new FactureType(), $entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * 
     *
     * @Route("/{id}/multiple/article/edit", name="facture_article_multiple_edit")
     * @Method("GET")
     * @Template("FMRFactureBundle:Facture:article_edit_multiple.html.twig")
     */
    public function multipleArticleEditAction(Facture $facture)
    {
    	$formArticles = $this->createForm(new FactureMultipleArticleType(), $facture);

        return array(
            'facture'      => $facture,
        	'formMultiple' => $formArticles->createView(),
        );
    }
    /**
     *
     *
     * @Route("/{id}/multiple/article/update", name="facture_article_multiple_update")
     * @Method("PUT")
     */
    public function multipleArticleUpdateAction(Request $request, Facture $facture)
    {
    	

    	$em = $this->getDoctrine()->getManager();
    	
    	$formArticles = $this->createForm(new FactureMultipleArticleType(), $facture);
    	$formArticles->bind($request);
    		
    		if ($formArticles->isValid()) {
    			$em->persist($facture);
    			foreach ($facture->getArticles() as $article){
    				$em->persist($article);
    			}
    		}
    	
    	$em->flush();
    	
    	$this->get('session')->getFlashBag()->add('success', 'Modification r&eacute;ussie');
    		 
    	return $this->redirect($this->generateUrl('facture_show', array('id' => $facture->getId())));
    }
    
    /**
     * Finds and displays a Facture entity.
     *
     * @Route("/{id}", name="facture_show")
     * @Method("GET")
     *
     * @Template()
     */
    public function showAction($id)
    {
    	
    	$em = $this->getDoctrine()->getManager();
    
    	$entity = $em->getRepository('FMRFactureBundle:Facture')->find($id);
    
    	if (!$entity) {
    		throw $this->createNotFoundException('Unable to find Facture entity.');
    	}
    
    	$formStatut = $this->createForm(new FactureChangeStatutType(), $entity);
    
    
    	return array(
    			'entity'      => $entity,
    			'formStatut' => $formStatut->createView(),
    	);
    }
    
    /**
     * Formattage de la facture en PDF ou en HTML selon le format
     *
     * @Route("/print/{id}", name="facture_print", defaults={"_format"="html"})
     * @Method("GET")
     *
     * @Pdf(stylesheet="::print-style.xml.twig")
     */
    public function printAction(Facture $entity)
    {
    	$format = $this->get('request')->get('_format');
    	 
    	$em = $this->getDoctrine()->getManager();
    	
    	if (!$entity->getDateImpression()) {
    		//Mise à jour de la date d'impression de la facture
			$dateImpression = new \DateTime();
			$entity->setDateImpression($dateImpression);
			//Changement du statut de la facture
			$statut = $em->getRepository('FMRFactureBundle:StatutFacture')->find(2);
			if ($statut) {
				$entity->setStatut($statut);
			}
			$em->persist($entity);
			$em->flush();
    	}

    	return $this->render(sprintf('FMRFactureBundle:Facture:print.%s.twig', $format), array(
    			'entity'      => $entity,
    	));
    }
    
    
    /**
     * Permet de changer le statut de la facture
     *
     * @Route("/{id}/statut", name="facture_statut")
     * @Method("PUT")
     * @Template("FMRFactureBundle:Facture:show.html.twig")
     */
    public function changeStatutAction(Request $request, Facture $facture)
    {
    	$em = $this->getDoctrine()->getManager();
    
    
    	$formStatut = $this->createForm(new FactureChangeStatutType(), $facture);
    
    	$formStatut->bind($request);
    
    	if ($formStatut->isValid()) {
    		$em->persist($facture);
    		$em->flush();
    
    		$this->get('session')->getFlashBag()->add('success', 'Modification du statut r&eacute;ussie');
    
    		return $this->redirect($this->generateUrl('facture_show', array('id' => $facture->getId())));
    	}
    
    	$this->get('session')->getFlashBag()->add('error', 'Erreur lors de la modification du statut');
    
    	return array(
    			'entity'      => $facture,
    			'formStatut' => $formStatut->createView(),
    	);
    }

    /**
     * Displays a form to edit an existing Facture entity.
     *
     * @Route("/{id}/edit", name="facture_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('FMRFactureBundle:Facture')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Facture entity.');
        }

        if (!$entity->isEditable()){
        	$this->get('session')->getFlashBag()->add('error', 'Facture vérouillée. Changez le statut pour pouvoir la modifier.');
        	return $this->redirect($this->generateUrl('facture_show', array('id' => $id)));
        }
        
        $editForm = $this->createForm(new FactureType(), $entity);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
        );
    }

    /**
     * Edits an existing Facture entity.
     *
     * @Route("/{id}", name="facture_update")
     * @Method("PUT")
     * @Template("FMRFactureBundle:Facture:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('FMRFactureBundle:Facture')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Facture entity.');
        }

        $editForm = $this->createForm(new FactureType(), $entity);
        $editForm->bind($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();
            
            $this->get('session')->getFlashBag()->add('success', 'Modification r&eacute;ussie');

            return $this->redirect($this->generateUrl('facture_show', array('id' => $entity->getId())));
        }
        
		$this->get('session')->getFlashBag()->add('error', 'Erreur lors de la modification');
        
        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
        );
    }

    /**
     * Deletes a Facture entity.
     *
     * @Route("/{id}/delete", name="facture_delete")
     *@Method("GET")
     */
	public function deleteAction($id)
	{
		$em = $this->getDoctrine()->getManager();
		$entity = $em->getRepository('FMRFactureBundle:Facture')->find($id);

		if (!$entity) {
			throw $this->createNotFoundException('Unable to find Facture entity.');
		}
		
		$em->remove($entity);
		$em->flush();
            
		$this->get('session')->getFlashBag()->add('success', 'Supression accomplie !');

		return $this->redirect($this->generateUrl('facture'));
	}
}
