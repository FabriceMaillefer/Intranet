<?php
namespace FMR\CommonBundle\Configurator\Step;

use Sensio\Bundle\DistributionBundle\Configurator\Step\StepInterface;

use FMR\CommonBundle\Configurator\Form\DatabaseCreateStepType;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\DBAL\DriverManager;

/**
 * DatabaseCreation Step.
 *
 *	Etape de création de la base de données
 *
 * @author Fabrice Maillefer <fabrice.maillefer@gmail.com>
 */
class SchemaCreateStep implements StepInterface
{
	/**
	 * Parametre du fichier parameters.yml
	 */
	protected $parameters;
	
	protected $kernel;
	
    public function __construct(array $parameters, $kernel = null)
    {
		$this->parameters = $parameters;
    	$this->kernel = $kernel;
    }

    /**
     * @see StepInterface
     */
    public function getFormType()
    {
    	return new DatabaseCreateStepType();
    }

    /**
     * @see StepInterface
     */
    public function checkRequirements()
    {
    	$messages = array();
    	
    	
    	
        return $messages;
    }

    /**
     * checkOptionalSettings
     */
    public function checkOptionalSettings()
    {
        return array();
    }

    /**
     * @see StepInterface
     */
    public function update(StepInterface $data)
    {
    	
    	$this->create();
    	
    	return array();
    }

    public function create(){

    	$application = new \Symfony\Bundle\FrameworkBundle\Console\Application($this->kernel);
    	$application->setAutoExit(false);

    	
    	//Create de Schema
    	$options = array('command' => 'doctrine:schema:create');
    	$application->run(new \Symfony\Component\Console\Input\ArrayInput($options));
    	
    	return true;
    }
    
    /**
     * @see StepInterface
     */
    public function getTemplate()
    {
        return 'FMRCommonBundle:Configurator/Step:schema_create.html.twig';
    }
}
