<?php

namespace FMR\RelationClientBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use FMR\RelationClientBundle\Entity\StatutDocument;

/**
 * LoadStatutDocumentData.
 *
 *	Chargement des données de base de l'application 
 * Création des statut pour les documents
 *
 * @author Fabrice Maillefer <fabrice.maillefer@gmail.com>
 */
class LoadStatutDocumentData implements FixtureInterface
{
	public function load(ObjectManager $manager)
	{
		//Statut "En création"
		$statut = new StatutDocument();
		$statut->setStatut('En création');
		$statut->setModifiable(true);
		$manager->persist($statut);
		
		//Statut "Envoyée au client"
		$statut = new StatutDocument();
		$statut->setStatut('Envoyée au client');
		$manager->persist($statut);
		
		//Statut "Acceptée"
		$statut = new StatutDocument();
		$statut->setStatut('Acceptée');
		$manager->persist($statut);
		
		//Statut "Refusée"
		$statut = new StatutDocument();
		$statut->setStatut('Refusée');
		$manager->persist($statut);
		
		//Statut "Payée"
		$statut = new StatutDocument();
		$statut->setStatut('Payée');
		$manager->persist($statut);
		
		$manager->flush();
	}
}