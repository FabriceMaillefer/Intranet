<?php

namespace FMR\OffreBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use FMR\OffreBundle\Entity\ArticleOffre;
use FMR\OffreBundle\Form\ArticleOffreType;
use FMR\OffreBundle\Entity\Offre;

/**
 * Contrôleur de l'entité Article d'offre
 *
 * @author Fabrice Maillefer <fabrice.maillefer@gmail.com>
 *
 * @Route("/articleoffre")
 */
class ArticleOffreController extends Controller
{
   
    /**
     * Creates a new ArticleOffre entity.
     *
     * @Route("/offre/{id}/", name="articleoffre_create")
     * @Method("POST")
     * @Template("FMROffreBundle:ArticleOffre:new.html.twig")
     */
    public function createAction(Request $request,Offre $offre)
    {
        $entity  = new ArticleOffre();
        $form = $this->createForm(new ArticleOffreType(), $entity);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity->setOffre($offre);
            $em->persist($entity);
            $em->flush();
            
			$this->get('session')->getFlashBag()->add('success', 'Cr&eacute;ation compl&egrave;te');
			
            return $this->redirect($this->generateUrl('offre_show', array('id' => $entity->getOffre()->getId())));
        }
		$this->get('session')->getFlashBag()->add('error', 'Erreur lors de la cr&eacute;ation');
        
        return array(
            'entity' => $entity,
        	'offre' => $offre,
            'form'   => $form->createView(),
        );
    }
    
    /**
     * Mise à jour de l'ordre des articles
     *
     * @Route("/sortable", name="articleoffre_sort")
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
				$article = $em->getRepository('FMROffreBundle:ArticleOffre')->find($idArticle);
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
     * Displays a form to create a new ArticleOffre entity.
     *
     * @Route("/offre/{id}/new", name="articleoffre_new")
     * @Method("GET")
     * @Template("FMROffreBundle:ArticleOffre:new_single.html.twig")
     */
    public function newAction(Offre $offre)
    {
        $entity = new ArticleOffre();
        $entity->setOffre($offre);
        $form   = $this->createForm(new ArticleOffreType(), $entity);

        return array(
            'entity' => $entity,
        	'offre' => $offre,
            'form'   => $form->createView(),
        );
    }


    /**
     * Displays a form to edit an existing ArticleOffre entity.
     *
     * @Route("/{id}/edit", name="articleoffre_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction(ArticleOffre $entity)
    {

        $editForm = $this->createForm(new ArticleOffreType(), $entity);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
        );
    }

    /**
     * Edits an existing ArticleOffre entity.
     *
     * @Route("/{id}", name="articleoffre_update")
     * @Method("PUT")
     * @Template("FMROffreBundle:ArticleOffre:edit.html.twig")
     */
    public function updateAction(Request $request, ArticleOffre $entity)
    {
        $em = $this->getDoctrine()->getManager();


        $editForm = $this->createForm(new ArticleOffreType(), $entity);
        $editForm->bind($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();
            
            $this->get('session')->getFlashBag()->add('success', 'Modification r&eacute;ussie');

            return $this->redirect($this->generateUrl('offre_show', array('id' => $entity->getOffre()->getId())));
        }
        
		$this->get('session')->getFlashBag()->add('error', 'Erreur lors de la modification');
        
        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
        );
    }

    /**
     * Deletes a ArticleOffre entity.
     *
     * @Route("/{id}/delete", name="articleoffre_delete")
     *@Method("GET")
     */
	public function deleteAction(ArticleOffre $entity)
	{
		$em = $this->getDoctrine()->getManager();

		$offre = $entity->getOffre();
		
		$em->remove($entity);
		$em->flush();
            
		$this->get('session')->getFlashBag()->add('success', 'Supression accomplie !');

		return $this->redirect($this->generateUrl('offre_show', array('id' => $offre->getId())));
	}
}
