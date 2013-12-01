<?php

namespace FMR\LignesBundle\Menu;

use FMR\LignesBundle\Event\ConfigureMenuEvent;
use Knp\Menu\FactoryInterface;
use Symfony\Component\DependencyInjection\ContainerAware;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class TypeBuilder extends ContainerAware
{
    public function typeMenu(FactoryInterface $factory, array $options)
    {
        $menu = $factory->createItem('root');    
       

        
        $menu->setChildrenAttribute('class', 'dropdown-menu');
	
        $menu->addChild('Article', array('route' => 'ligne_new', 'routeParameters' => array('type' => 'Article', 'id'=>$options['relation_id'])));
        $menu->addChild('Article 1D', array('route' => 'ligne_new', 'routeParameters' => array('type' => 'Article1D', 'id'=>$options['relation_id'])));
        $menu->addChild('Article 2D', array('route' => 'ligne_new', 'routeParameters' => array('type' => 'Article2D', 'id'=>$options['relation_id'])));
        $menu->addChild('Article 3D', array('route' => 'ligne_new', 'routeParameters' => array('type' => 'Article3D', 'id'=>$options['relation_id'])));
        $menu->addChild('Titre', array('route' => 'ligne_new', 'routeParameters' => array('type' => 'Titre', 'id'=>$options['relation_id'])));
        

        return $menu;
    }
}