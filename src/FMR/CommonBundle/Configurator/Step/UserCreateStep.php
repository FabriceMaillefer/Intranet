<?php
namespace FMR\CommonBundle\Configurator\Step;

use Sensio\Bundle\DistributionBundle\Configurator\Step\StepInterface;

use FMR\CommonBundle\Configurator\Form\UserCreateStepType;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\DBAL\DriverManager;

/**
 * UserCreateStep Step.
 *
 *	Etape de création d'un utilisateur de l'application
 *
 * @author Fabrice Maillefer <fabrice.maillefer@gmail.com>
 */
class UserCreateStep implements StepInterface
{
	/**
	 * Parametre du fichier parameters.yml
	 */
	protected $parameters;
	
	protected $userManipulator;
	
	
	/**
	 * @Assert\NotBlank
	 */
	public $username;
	/**
	 * @Assert\NotBlank
	 */
	public $password;
	/**
	 * @Assert\Email
	 */
	public $email;
	
    public function __construct(array $parameters, $userManipulator = null)
    {
		$this->parameters = $parameters;
    	$this->userManipulator = $userManipulator;
    }

    /**
     * @see StepInterface
     */
    public function getFormType()
    {
    	return new UserCreateStepType();
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
    	$this->userManipulator->create($this->username, $this->password, $this->email, true, true);
    	
    	return array();
    }
    
    /**
     * @see StepInterface
     */
    public function getTemplate()
    {
        return 'FMRCommonBundle:Configurator/Step:user_create.html.twig';
    }
}
