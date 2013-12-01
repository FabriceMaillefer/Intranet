<?php

namespace FMR\RelationClientBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * StatutDocument
 *
 * @author Fabrice Maillefer <fabrice.maillefer@gmail.com>
 * 
 * @ORM\Table()
 * @ORM\Entity
 */
class StatutDocument
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(name="Statut", type="string", length=255)
     */
    private $statut;
    
    /**
     * @var bool
     *
     * @ORM\Column(name="IsModifiable", type="boolean")
     */
    private $modifiable;

    public function __toString(){
    	return $this->statut;
    }
    public function __construct() {
    	$this->modifiable = false;
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
     * Set statut
     *
     * @param string $statut
     * @return StatutDocument
     */
    public function setStatut($statut)
    {
        $this->statut = $statut;
    
        return $this;
    }

    /**
     * Get statut
     *
     * @return string 
     */
    public function getStatut()
    {
        return $this->statut;
    }

    /**
     * Set isModifiable
     *
     * @param boolean $isModifiable
     * @return StatutDocument
     */
    public function setModifiable($modifiable)
    {
        $this->modifiable = $modifiable;
    
        return $this;
    }

    /**
     * Get isModifiable
     *
     * @return boolean 
     */
    public function isModifiable()
    {
        return $this->modifiable;
    }

    /**
     * Get modifiable
     *
     * @return boolean 
     */
    public function getModifiable()
    {
        return $this->modifiable;
    }
}