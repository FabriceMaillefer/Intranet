<?php

namespace FMR\LignesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Knp\DoctrineBehaviors\Model as ORMBehaviors;

/**
 * Entité Ligne
 *
 * @author Fabrice Maillefer <fabrice.maillefer@gmail.com>
 *
 * @ORM\Table()
 * @ORM\Entity()
 * @ORM\InheritanceType("JOINED")
 * @ORM\DiscriminatorColumn(name="type_class", type="string")
 */
abstract class Ligne
{
	use ORMBehaviors\Timestampable\Timestampable,
	ORMBehaviors\Blameable\Blameable;
	/*
	 * Attributs
	 */
	
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

	/**
	 *
	 *
	 * @ORM\ManyToOne(targetEntity="FMR\RelationClientBundle\Entity\RelationClientAvecLigne", inversedBy="lignes")
	 * @ORM\JoinColumn(name="relation_client_id", referencedColumnName="id", nullable=false)
	 */
	private $relationClient;
    
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="DateCreation", type="datetime")
     */
    private $dateCreation;
    
    /**
     * @var integer
     *
     * @ORM\Column(name="Ordre", type="integer")
     */
    private $ordre;

    public function getType(){
    
    	$class = explode('\\', (is_string($this) ? $this : get_class($this)));
    	return $class[count($class) - 1];
    }
    
    /*
     * Methode magique
     */

    public function __construct() {
    	$this->dateCreation = new \DateTime();
    	$this->ordre  = 0;
    }

	public function getLabelAjout(){
		return "Ajouter une ligne";
	}
	
	public function CalculPrix(){
		return 0;
	}

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set dateCreation
     *
     * @param \DateTime $dateCreation
     * @return Ligne
     */
    public function setDateCreation($dateCreation)
    {
        $this->dateCreation = $dateCreation;
    
        return $this;
    }

    /**
     * Get dateCreation
     *
     * @return \DateTime 
     */
    public function getDateCreation()
    {
        return $this->dateCreation;
    }

    /**
     * Set ordre
     *
     * @param integer $ordre
     * @return Ligne
     */
    public function setOrdre($ordre)
    {
        $this->ordre = $ordre;
    
        return $this;
    }

    /**
     * Get ordre
     *
     * @return integer 
     */
    public function getOrdre()
    {
        return $this->ordre;
    }

    /**
     * Set relationClientAvecLigne
     *
     * @param \FMR\RelationClientBundle\Entity\RelationClientAvecLigne $relationClientAvecLigne
     * 
     */
    public function setRelationClient(\FMR\RelationClientBundle\Entity\RelationClientAvecLigne $relationClientAvecLigne)
    {
        $this->relationClient = $relationClientAvecLigne;
    
        return $this;
    }

    /**
     * Get relationClientAvecLigne
     *
     * @return \FMR\RelationClientBundle\Entity\RelationClientAvecLigne
     */
    public function getRelationClient()
    {
        return $this->relationClient;
    }
}