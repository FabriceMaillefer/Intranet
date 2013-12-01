<?php

namespace FMR\RelationClientBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Entité RelationClient
 *
 * @author Fabrice Maillefer <fabrice.maillefer@gmail.com>
 *
 * @ORM\Table()
 * @ORM\Entity()
 * @ORM\InheritanceType("JOINED")
 * @ORM\DiscriminatorColumn(name="type_class", type="string")
 * @ORM\HasLifecycleCallbacks
 */
abstract class RelationClient
{
	
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
     * @var \DateTime
     *
     * @ORM\Column(name="DateCreation", type="datetime")
     */
    private $dateCreation;

    /**
     * @var FMR\ClientBundle\Entity\Client
     *
     * @ORM\ManyToOne(targetEntity="FMR\ClientBundle\Entity\Client", inversedBy="relationClient")
     * @ORM\JoinColumn(name="client_id", referencedColumnName="id", nullable=false)
     */
    private $client;
    
    /**
     * @ORM\Column(type="datetime")
     */
    private $dateModification;
    
    /**
     * 
     *
     * @ORM\ManyToOne(targetEntity="FMR\RelationClientBundle\Entity\RelationClient", inversedBy="relationParent")
     * @ORM\JoinColumn(name="relationEnfant", referencedColumnName="id", nullable=true)
     */
    private $relationEnfant;
    
    /**
     *
     *
	 * @ORM\OneToMany(targetEntity="FMR\RelationClientBundle\Entity\RelationClient", mappedBy="relationEnfant")
     */
    private $relationParent;
    
    /**
     * @ORM\PrePersist
     * @ORM\PreUpdate
     */
    public function updateTimestamps()
    {
    	$this->setDateModification(new \DateTime());
   
    }

    /*
     * Methodes magiques
     */
    
    public function __construct() {
    	$this->dateCreation = new \DateTime();
    }
    public function __toString() {
    	return $this->getId();
    }
    
    public function getRoute() {
    	return 'relationclient';
    }

    /*
     * Getter et Setter
     */
    

    public function getType(){
    
    	$class = explode('\\', (is_string($this) ? $this : get_class($this)));
    	return $class[count($class) - 1];
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
     * @return RelationClient
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
     * Set client
     *
     * @param \FMR\ClientBundle\Entity\Client $client
     * @return RelationClient
     */
    public function setClient(\FMR\ClientBundle\Entity\Client $client)
    {
        $this->client = $client;
    
        return $this;
    }

    /**
     * Get client
     *
     * @return \FMR\ClientBundle\Entity\Client 
     */
    public function getClient()
    {
        return $this->client;
    }

    /**
     * Set dateModification
     *
     * @param \DateTime $dateModification
     * @return RelationClient
     */
    public function setDateModification($dateModification)
    {
        $this->dateModification = $dateModification;
    
        return $this;
    }

    /**
     * Get dateModification
     *
     * @return \DateTime 
     */
    public function getDateModification()
    {
        return $this->dateModification;
    }

    /**
     * Set relationEnfant
     *
     * @param \FMR\RelationClientBundle\Entity\RelationClient $relationEnfant
     * @return RelationClient
     */
    public function setRelationEnfant(\FMR\RelationClientBundle\Entity\RelationClient $relationEnfant = null)
    {
        $this->relationEnfant = $relationEnfant;
    
        return $this;
    }

    /**
     * Get relationEnfant
     *
     * @return \FMR\RelationClientBundle\Entity\RelationClient 
     */
    public function getRelationEnfant()
    {
        return $this->relationEnfant;
    }

    /**
     * Add relationParent
     *
     * @param \FMR\RelationClientBundle\Entity\RelationClient $relationParent
     * @return RelationClient
     */
    public function addRelationParent(\FMR\RelationClientBundle\Entity\RelationClient $relationParent)
    {
        $this->relationParent[] = $relationParent;
    
        return $this;
    }

    /**
     * Remove relationParent
     *
     * @param \FMR\RelationClientBundle\Entity\RelationClient $relationParent
     */
    public function removeRelationParent(\FMR\RelationClientBundle\Entity\RelationClient $relationParent)
    {
        $this->relationParent->removeElement($relationParent);
    }

    /**
     * Get relationParent
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getRelationParent()
    {
        return $this->relationParent;
    }
}