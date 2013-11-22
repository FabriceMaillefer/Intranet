<?php

namespace FMR\OffreBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use FMR\OffreBundle\Entity\StatutOffre;

/**
 * LoadStatutOffreData.
 *
 *	Chargement des données de base de l'application 
 * Création des statut pour les offres
 *
 * @author Fabrice Maillefer <fabrice.maillefer@gmail.com>
 */
class LoadStatutOffreData implements FixtureInterface
{
	public function load(ObjectManager $manager)
	{
		//Statut "En création"
		$statut = new StatutOffre();
		$statut->setStatut('En création');
		$manager->persist($statut);
		
		//Statut "Envoyée au client"
		$statut = new StatutOffre();
		$statut->setStatut('Envoyée au client');
		$manager->persist($statut);
		
		//Statut "Acceptée"
		$statut = new StatutOffre();
		$statut->setStatut('Acceptée');
		$manager->persist($statut);
		
		//Statut "Refusée"
		$statut = new StatutOffre();
		$statut->setStatut('Refusée');
		$manager->persist($statut);
		
		$manager->flush();
	}
}