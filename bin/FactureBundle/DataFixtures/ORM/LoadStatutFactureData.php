<?php

namespace FMR\FactureBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use FMR\FactureBundle\Entity\StatutFacture;

/**
 * LoadStatutOffreData.
 *
 *	Chargement des données de base de l'application
 *  Création des statuts pour les factures
 *
 * @author Fabrice Maillefer <fabrice.maillefer@gmail.com>
 */
class LoadStatutFactureData implements FixtureInterface
{
	public function load(ObjectManager $manager)
	{
		//Statut "En création"
		$statut = new StatutFacture();
		$statut->setStatut('En création');
		$manager->persist($statut);
		
		//Statut "Envoyée au client"
		$statut = new StatutFacture();
		$statut->setStatut('Envoyée au client');
		$manager->persist($statut);
		
		//Statut "Payée"
		$statut = new StatutFacture();
		$statut->setStatut('Payée');
		$manager->persist($statut);
		
		$manager->flush();
	}
}