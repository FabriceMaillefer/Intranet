<?php

namespace FMR\ChantierBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * ChantierRepository
 * @author Fabrice Maillefer
 */
class ChantierRepository extends EntityRepository
{
	
	/**
	 * Recherche des chantiers
	 */
	public function search($q){
		$qb = $this->getEntityManager()->createQueryBuilder();
	
		$qb
    	->select('h')
    	->from('FMRChantierBundle:Chantier', 'h')
    	->innerJoin('h.client', 'c')
		->where('CONCAT(c.nom, CONCAT(\' \', c.prenom)) LIKE ?1')
		->orWhere('CONCAT(c.prenom, CONCAT(\' \', c.nom)) LIKE ?1')
    	->orWhere('CONCAT(\'client:\', c.id) = ?2')
    	->orWhere('h.description LIKE ?1')
    	->orWhere('h.architecte LIKE ?1')
    	->orWhere('h.lieu LIKE ?1')
    	->orWhere('h.id = ?2')
    	->setParameter('1','%'.$q.'%')
    	->setParameter('2',$q)
    	;
	
		$query = $qb->getQuery();
		return $query->getResult();
	}
	
	/**
	 * Selection des chantiers en cours
	 *
	 */
	public function findAllActive()
	{
		$qb = $this->getEntityManager()->createQueryBuilder();
	
		$qb
		->select('h')
		->from('FMRChantierBundle:Chantier', 'h')
		->innerJoin('h.client', 'c')
		->andWhere('(h.dateFin >= ?2 OR h.dateFin is null)')
		->setParameter('2', new \DateTime())
		;
	
		$query = $qb->getQuery();
		return $query->getResult();
	}
	
	/**
	 * Selection des chantiers en cours pour un client
	 *
	 * @param \FMR\ClientBundle\Entity\Client $client
	 */
	public function findAllActiveForClient(\FMR\ClientBundle\Entity\Client $client)
	{
		$qb = $this->getEntityManager()->createQueryBuilder();
	
		$qb
        ->select('h')
    	->from('FMRChantierBundle:Chantier', 'h')
        ->innerJoin('h.client', 'c')
        ->where('c.id = ?1')
        ->andWhere('(h.dateFin >= ?2 OR h.dateFin is null)')
        ->setParameter('1',$client->getId())
        ->setParameter('2', new \DateTime())
        ;
	
		$query = $qb->getQuery();
		return $query->getResult();
	}
}
