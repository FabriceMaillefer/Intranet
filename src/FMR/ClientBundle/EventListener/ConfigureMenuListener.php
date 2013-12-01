<?php

namespace FMR\ClientBundle\EventListener;

use FMR\CommonBundle\Event\ConfigureMenuEvent;

class ConfigureMenuListener
{
	
    /**
     * @param \FMR\CommonBundle\Event\ConfigureMenuEvent $event
     */
    public function onMenuConfigure(ConfigureMenuEvent $event)
    {
        $menu = $event->getMenu();

       $menu->addChild('Client', array('route' => 'client'))
        	->setAttribute('icon', 'icon-user');
        $menu['Client']
        	->addChild('Ajouter un nouveau client', array('route' => 'client_new'));
    }
}