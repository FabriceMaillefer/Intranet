<?php
namespace FMR\CommonBundle\Command;
use Sensio\Bundle\GeneratorBundle\Generator\DoctrineCrudGenerator;
use Sensio\Bundle\GeneratorBundle\Command\GenerateDoctrineCrudCommand;

class DoctrineGenerateCrudTwitterBootstrapCommand extends GenerateDoctrineCrudCommand
{

	protected function configure()
	{
		parent::configure();
		$this->setName('doctrine:generate:crud:fmr');
	}

	protected function getGenerator($bundle = null) {
		$generator = new DoctrineCrudGenerator($this->getContainer()->get('filesystem'), __DIR__.'/../Resources/skeleton/crud');
		$this->setGenerator($generator);
		return parent::getGenerator($bundle);
	}

}
