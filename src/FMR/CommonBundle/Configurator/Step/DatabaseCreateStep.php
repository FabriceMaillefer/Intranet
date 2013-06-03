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
class DatabaseCreateStep implements StepInterface
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
    	$options = array('command' => 'doctrine:database:create');
    	$application->run(new \Symfony\Component\Console\Input\ArrayInput($options));
    	
    	/*
    	
    	$name = isset($this->parameters['database_path']) ? $this->parameters['database_path'] : (isset($this->parameters['database_name']) ? $this->parameters['database_name'] : false);
    	if (!$name) {
    		throw new \InvalidArgumentException("Connection does not contain a 'path' or 'dbname' parameter and cannot be dropped.");
    	}
    	unset($this->parameters['database_name']);
    	
    	$this->parameters['driver'] = $this->parameters['database_driver'];
    	$this->parameters['user'] = $this->parameters['database_user'];
    	$this->parameters['password'] = $this->parameters['database_password'];
    	$this->parameters['port'] = $this->parameters['database_port'];
    	
    	$tmpConnection = DriverManager::getConnection($this->parameters);
    	 
    	// Only quote if we don't have a path
    	if (!isset($this->parameters['database_path'])) {
    		$name = $tmpConnection->getDatabasePlatform()->quoteSingleIdentifier($name);
    	}

    	try {
    		$tmpConnection->getSchemaManager()->createDatabase($name);
    		print_r(sprintf('<info>Created database for connection named <comment>%s</comment></info>', $name));
    	} catch (\Exception $e) {
    		$this->erreur += sprintf('<error>Could not create database for connection named <comment>%s</comment></error>', $name);
    		$this->erreur += sprintf('<error>%s</error>', $e->getMessage());
    		$error = true;
    		print_r($e->getMessage());
    		exit();
    	}
    	 
    	$tmpConnection->close();
    	
    	return !$error;
    	*/
    	return true;
    }
    
    /**
     * @see StepInterface
     */
    public function getTemplate()
    {
        return 'FMRCommonBundle:Configurator/Step:database_create.html.twig';
    }
}
