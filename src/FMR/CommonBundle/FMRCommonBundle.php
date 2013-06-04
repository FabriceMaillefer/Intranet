<?php

namespace FMR\CommonBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;
use FMR\CommonBundle\Configurator\Step\DatabaseCreateStep;
use FMR\CommonBundle\Configurator\Step\SchemaCreateStep;
/**
 *
 * @author Fabrice Maillefer <fabrice.maillefer@gmail.com>
 *
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
		}
	}
}
