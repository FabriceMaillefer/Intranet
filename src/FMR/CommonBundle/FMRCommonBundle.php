<?php

namespace FMR\CommonBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;
use FMR\CommonBundle\Configurator\Step\DatabaseCreateStep;
use FMR\CommonBundle\Configurator\Step\SchemaCreateStep;

class FMRCommonBundle extends Bundle
{
	public function boot()
	{
		$kernel = $this->container->get('kernel');
		$configurator = $this->container->get('sensio.distribution.webconfigurator');
		$configurator->addStep(new DatabaseCreateStep($configurator->getParameters(),$kernel));
		$configurator->addStep(new SchemaCreateStep($configurator->getParameters(),$kernel));
	}
}
