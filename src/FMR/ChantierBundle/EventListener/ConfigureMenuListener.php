<?php

namespace FMR\ChantierBundle\EventListener;

use FMR\CommonBundle\Event\ConfigureMenuEvent;

class ConfigureMenuListener
{
	
    /**
     * @param \FMR\CommonBundle\Event\ConfigureMenuEvent $event
     */
    public function onMenuConfigure(ConfigureMenuEvent $event)
    {
        $menu = $event->getMenu();

        $menu->addChild('Chantier', array('route' => 'chantier'));
       
    }
}