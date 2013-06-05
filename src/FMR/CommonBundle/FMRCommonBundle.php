<?php

namespace FMR\CommonBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;
use FMR\CommonBundle\Configurator\Step\DatabaseCreateStep;
use FMR\CommonBundle\Configurator\Step\SchemaCreateStep;
use FMR\CommonBundle\Configurator\Step\UserCreateStep;

/**
 *
 * Bundle Common
 * @author Fabrice Maillefer <fabrice.maillefer@gmail.com>
 *
 *
 * Contient les étapes de configurations
 */
class FMRCommonBundle extends Bundle
{
	public function boot()
	{
		//Activation du configurator seulement dans l'environement de développement
		$kernel = $this->container->get('kernel');
		if(in_array($kernel->getEnvironment(), array('test', 'dev'))) {
			$configurator = $this->container->get('sensio.distribution.webconfigurator');
			
			//Etape de la création de la base de données
			$configurator->addStep(new DatabaseCreateStep($configurator->getParameters(),$kernel));
			//Etape de la création des tables
			$configurator->addStep(new SchemaCreateStep($configurator->getParameters(),$kernel));
			//Etape de la création des utilisateurs
			$userManipulator = $this->container->get('fos_user.util.user_manipulator');
			$configurator->addStep(new UserCreateStep($configurator->getParameters(),$userManipulator));
			
		}
	}
}
