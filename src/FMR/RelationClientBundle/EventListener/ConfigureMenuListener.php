<?php

namespace FMR\RelationClientBundle\EventListener;

use FMR\CommonBundle\Event\ConfigureMenuEvent;

class ConfigureMenuListener
{
	
    /**
     * @param \FMR\CommonBundle\Event\ConfigureMenuEvent $event
     */
    public function onMenuConfigure(ConfigureMenuEvent $event)
    {
        $menu = $event->getMenu();

        $menu->addChild('Factures', array('route' => 'facture'));
        $menu->addChild('Offres', array('route' => 'offre'));
        $menu->addChild('Commande', array('route' => 'commande'));
    }
}