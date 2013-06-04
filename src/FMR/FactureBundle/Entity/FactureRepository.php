<?php

namespace FMR\FactureBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * FactureRepository
 * @author Fabrice Maillefer <fabrice.maillefer@gmail.com>
 */
class FactureRepository extends EntityRepository
{
	
	/**
	 * Retourne les dernières factures créées
	 */
	public function findRecents($limit = 10)
	{
		$qb = $this->getEntityManager()->createQueryBuilder();
	
		$qb
		->select('f')
		->from('FMRFactureBundle:Facture', 'f')
		->innerJoin('f.statut', 's')
		->orderBy('f.dateCreation', 'DESC')
		->where('s.id IN (1, 2)')
		->setMaxResults($limit)
		;
	
		$query = $qb->getQuery();
		return $query->getResult();
	}
	
	/**
	 * Recherche des factures
	 */
	public function search($q){
		$qb = $this->getEntityManager()->createQueryBuilder();
    
    	$qb
	    	->select('f')
	    	->from('FMRFactureBundle:Facture', 'f')
	    	->innerJoin('f.client', 'c')
			->where('CONCAT(c.nom, CONCAT(\' \', c.prenom)) LIKE ?1')
			->orWhere('CONCAT(c.prenom, CONCAT(\' \', c.nom)) LIKE ?1')
	    	->orWhere('CONCAT(\'client:\', c.id) = ?2')
	    	->orWhere('f.referenceClient LIKE ?1')
	    	->orWhere('f.id = ?2')
	    	->setParameter('1','%'.$q.'%')
	    	->setParameter('2',$q)
    	;
		
		$query = $qb->getQuery();
		return $query->getResult();
	}
	
	/**
	 * Selection des factures en cours
	 *
	 */
	public function findAllActive()
	{
		$qb = $this->getEntityManager()->createQueryBuilder();
	
		$qb
		->select('f')
		->from('FMRFactureBundle:Facture', 'f')
		->innerJoin('f.statut', 's')
		->andWhere('s.id IN (1, 2)')
		;
	
		$query = $qb->getQuery();
		return $query->getResult();
	}
	
	/**
	 * Selection des factures en cours pour un client
	 * 
	 * @param \FMR\ClientBundle\Entity\Client $client
	 * 
	 */
	public function findAllActiveForClient(\FMR\ClientBundle\Entity\Client $client)
	{
		$qb = $this->getEntityManager()->createQueryBuilder();

		$qb
		->select('f')
		->from('FMRFactureBundle:Facture', 'f')
		->innerJoin('f.client', 'c')
		->innerJoin('f.statut', 's')
		->where('c.id = ?1')
		->andWhere('s.id IN (1, 2)')
		->setParameter('1',$client->getId())
		;
		
		$query = $qb->getQuery();
		return $query->getResult();
	}
}
