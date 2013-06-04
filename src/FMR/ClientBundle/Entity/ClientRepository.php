<?php

namespace FMR\ClientBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * ClientRepository
 * @author Fabrice Maillefer
 */
class ClientRepository extends EntityRepository
{
	/** 
	 * Retourne les derniers clients créés
	 */
	public function findRecents($limit = 10)
	{
		return $this->getEntityManager()
		->createQuery('SELECT c FROM FMRClientBundle:Client c ORDER BY c.dateCreation DESC ')
		->setMaxResults($limit)
		->getResult();
	}
	
	/**
	 * Recherche des clients
	 */
	public function search($q){
		
		$qb = $this->getEntityManager()->createQueryBuilder();
	 
		$qb
		->select('c')
		->from('FMRClientBundle:Client', 'c')
		->where('CONCAT(c.nom, CONCAT(\' \', c.prenom)) LIKE ?1')
		->orWhere('CONCAT(c.prenom, CONCAT(\' \', c.nom)) LIKE ?1')
		->orWhere('c.adresse LIKE ?1')
		->orWhere('c.tel LIKE ?1')
		->orWhere('c.localite LIKE ?1')
		->orWhere('c.id = ?2')
		->setParameter('1','%'.$q.'%')
		->setParameter('2',$q)
		;
	 
		$query = $qb->getQuery();
		return $query->getResult();
	}
	
}
