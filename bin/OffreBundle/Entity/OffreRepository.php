<?php

namespace FMR\OffreBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * OffreRepository
 *
 * @author Fabrice Maillefer <fabrice.maillefer@gmail.com>
 */
class OffreRepository extends EntityRepository
{	
	
	/**
	 * Retourne les dernières offres créées
	 */
	public function findRecents($limit = 10)
	{
		$qb = $this->getEntityManager()->createQueryBuilder();
		
		$qb
		->select('o')
		->from('FMROffreBundle:Offre', 'o')
		->innerJoin('o.statut', 's')
		->orderBy('o.dateCreation', 'DESC')
		->where('s.id IN (1, 2)')
		->setMaxResults($limit)
		;
				
		$query = $qb->getQuery();
		return $query->getResult();
	}
	
	/**
	 * Recherche des offres
	 */
	public function search($q){
		$qb = $this->getEntityManager()->createQueryBuilder();
	
		$qb
		->select('o')
		->from('FMROffreBundle:Offre', 'o')
		->innerJoin('o.client', 'c')
		->where('CONCAT(c.nom, CONCAT(\' \', c.prenom)) LIKE ?1')
		->orWhere('CONCAT(c.prenom, CONCAT(\' \', c.nom)) LIKE ?1')
		->orWhere('CONCAT(\'client:\', c.id) = ?2')
		->orWhere('o.referenceClient LIKE ?1')
		->orWhere('o.id = ?2')
		->setParameter('1','%'.$q.'%')
		->setParameter('2',$q)
		;
	
		$query = $qb->getQuery();
		return $query->getResult();
	}
	
	/**
	 * Selection des offres en cours
	 *
	 */
	public function findAllActive()
	{
		$qb = $this->getEntityManager()->createQueryBuilder();
	
		$qb
		->select('o')
		->from('FMROffreBundle:Offre', 'o')
		->innerJoin('o.statut', 's')
		->andWhere('s.id IN (1, 2)')
		;
	
		$query = $qb->getQuery();
		return $query->getResult();
	}
	
	/**
	 * Selection des offres en cours pour un client
	 * 
	 * @param \FMR\ClientBundle\Entity\Client $client
	 */
	public function findAllActiveForClient(\FMR\ClientBundle\Entity\Client $client)
	{
		$qb = $this->getEntityManager()->createQueryBuilder();
	
		$qb
        ->select('o')
        ->from('FMROffreBundle:Offre', 'o')
        ->innerJoin('o.client', 'c')
        ->innerJoin('o.statut', 's')
        ->where('c.id = ?1')
        ->andWhere('s.id IN (1, 2)')
        ->setParameter('1',$client->getId())
        ;
	
		$query = $qb->getQuery();
		return $query->getResult();
	}
}
