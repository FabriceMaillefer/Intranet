<?php

namespace FMR\CommonBundle\Menu;

use FMR\CommonBundle\Event\ConfigureMenuEvent;
use Knp\Menu\FactoryInterface;
use Symfony\Component\DependencyInjection\ContainerAware;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class MainBuilder
{
	private $dispatcher;
	private $factory;

	public function __construct(FactoryInterface $factory, EventDispatcherInterface $dispatcher){
		$this->dispatcher = $dispatcher;
		$this->factory = $factory;
	}
    public function createMainMenu()
    {
        $menu = $this->factory->createItem('root');    
        
        $menu->setChildrenAttribute('class', 'nav navbar-nav');

        $this->dispatcher->dispatch(ConfigureMenuEvent::CONFIGURE, new ConfigureMenuEvent($this->factory, $menu));

        return $menu;
    }
}