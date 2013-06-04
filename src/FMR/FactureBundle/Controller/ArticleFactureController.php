<?php

namespace FMR\FactureBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use FMR\FactureBundle\Entity\ArticleFacture;
use FMR\FactureBundle\Form\ArticleFactureType;
use FMR\FactureBundle\Entity\Facture;

/**
 * Contrôleur de l'entité Article de Facture
 *
 * @author Fabrice Maillefer <fabrice.maillefer@gmail.com>
 *
 * @Route("/articlefacture")
 */
class ArticleFactureController extends Controller
{
    
    /**
     * Mise à jour de l'ordre des articles
     *
     * @Route("/sortable", name="articlefacture_sort")
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
			foreach ($sort as $index_ordre => $idArticle) {
				//Récupération de l’article depuis la base de données
				$article = $em->getRepository('FMRFactureBundle:ArticleFacture')->find($idArticle);
				//Si l’article existe :
				if ($article) {
					//modifie l’ordre de l’article
					$article->setOrdre($index_ordre);
					//sauve l’entité
					$em->persist($article);
				}
			}
			//Execute les requêtes
			$em->flush();  		 
		}
		return new Response('Ordre ok');
    }
    

    /**
     * Creates a new ArticleFacture entity.
     *
     * @Route("/facture/{id}", name="articlefacture_create")
     * @Method("POST")
     * @Template("FMRFactureBundle:ArticleFacture:new.html.twig")
     */
    public function createAction(Request $request, Facture $facture)
    {
        $entity  = new ArticleFacture();
        $form = $this->createForm(new ArticleFactureType(), $entity);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity->setFacture($facture);
            $em->persist($entity);
            $em->flush();
            
			$this->get('session')->getFlashBag()->add('success', 'Cr&eacute;ation compl&egrave;te');
		
            return $this->redirect($this->generateUrl('facture_show', array('id' => $entity->getFacture()->getId())));
		}
		$this->get('session')->getFlashBag()->add('error', 'Erreur lors de la cr&eacute;ation');
        
        return array(
            'entity' => $entity,
        	'facture' => $facture,
            'form'   => $form->createView(),
        );
    }

    /**
     * Displays a form to create a new ArticleFacture entity.
     *
     * @Route("/facture/{id}/new", name="articlefacture_new")
     * @Method("GET")
     * @Template("FMRFactureBundle:ArticleFacture:new_single.html.twig")
     */
    public function newAction(Facture $facture)
    {
        $entity = new ArticleFacture();
        $entity->setFacture($facture);
        $form   = $this->createForm(new ArticleFactureType(), $entity);
	
        return array(
            'entity' => $entity,
        	'facture' => $facture,
            'form'   => $form->createView(),
        );
    }

    /**
     * Displays a form to edit an existing ArticleFacture entity.
     *
     * @Route("/{id}/edit", name="articlefacture_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction(ArticleFacture $entity)
    {

        $editForm = $this->createForm(new ArticleFactureType(), $entity);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
        );
    }

    /**
     * Edits an existing ArticleFacture entity.
     *
     * @Route("/{id}", name="articlefacture_update")
     * @Method("PUT")
     * @Template("FMRFactureBundle:ArticleFacture:edit.html.twig")
     */
    public function updateAction(Request $request, ArticleFacture $entity)
    {
        $em = $this->getDoctrine()->getManager();


        $editForm = $this->createForm(new ArticleFactureType(), $entity);
        $editForm->bind($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();
            
            $this->get('session')->getFlashBag()->add('success', 'Modification r&eacute;ussie');

          	return $this->redirect($this->generateUrl('facture_show', array('id' => $entity->getFacture()->getId())));
        }
        
		$this->get('session')->getFlashBag()->add('error', 'Erreur lors de la modification');
        
        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
        );
    }

    /**
     * Deletes a ArticleFacture entity.
     *
     * @Route("/{id}/delete", name="articlefacture_delete")
     *@Method("GET")
     */
	public function deleteAction(ArticleFacture $entity)
	{
		$em = $this->getDoctrine()->getManager();

		$facture = $entity->getFacture();
		
		
		$em->remove($entity);
		$em->flush();
            
		$this->get('session')->getFlashBag()->add('success', 'Supression accomplie !');

		return $this->redirect($this->generateUrl('facture_show', array('id' => $facture->getId())));
	}
}
