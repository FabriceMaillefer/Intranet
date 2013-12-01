<?php

namespace FMR\RelationClientBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Entité RelationClientAvecLigne
 *
 * @author Fabrice Maillefer <fabrice.maillefer@gmail.com>
 * 
 * @ORM\Table()
 * @ORM\Entity()
 */
abstract class RelationClientAvecLigne extends RelationClient
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
	* @ORM\OneToMany(targetEntity="FMR\LignesBundle\Entity\Ligne", mappedBy="relationClient")
	* @ORM\OrderBy({"ordre" = "ASC"})
	*/
	private $lignes;
	
    /*
     * Methodes magiques
     */
    
    public function __construct() {
    	parent::__construct();
    	$this->lignes = new \Doctrine\Common\Collections\ArrayCollection();
    }
    public function __toString() {
    	return $this->getId();
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
     * Add lignes
     *
     * @param \FMR\LignesBundle\Entity $lignes
     * @return ListeLignes
     */
    public function addLigne(\FMR\LignesBundle\Entity $lignes)
    {
    	$this->lignes[] = $lignes;
    
    	return $this;
    }
    
    /**
     * Remove lignes
     *
     * @param \FMR\LignesBundle\Entity $lignes
     */
    public function removeLigne(\FMR\LignesBundle\Entity $lignes)
    {
    	$this->lignes->removeElement($lignes);
    }
    
    /**
     * Get lignes
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getLignes()
    {
    	return $this->lignes;
    }
}