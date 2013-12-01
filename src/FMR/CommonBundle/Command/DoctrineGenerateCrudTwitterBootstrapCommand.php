<?php
namespace FMR\CommonBundle\Command;
use Sensio\Bundle\GeneratorBundle\Generator\DoctrineCrudGenerator;
use Sensio\Bundle\GeneratorBundle\Command\GenerateDoctrineCrudCommand;
use Symfony\Component\HttpKernel\Bundle\BundleInterface;

/**
 * Générateur personalisé de CRUD
 *
 * @author Fabrice Maillefer <fabrice.maillefer@gmail.com>
 */
class DoctrineGenerateCrudTwitterBootstrapCommand extends GenerateDoctrineCrudCommand
{

	protected function configure()
	{
		parent::configure();
		$this->setName('doctrine:generate:crud:fmr');
	}

	protected function getGenerator(BundleInterface $bundle = null) {
		$generator = new DoctrineCrudGenerator($this->getContainer()->get('filesystem'), __DIR__.'/../Resources/skeleton/crud');
		$this->setGenerator($generator);
		return parent::getGenerator($bundle);
	}

}
