<?php

namespace FMR\ChantierBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use FMR\ChantierBundle\Form\Fourniture1DType as FournitureType;
/**
 * Fourniture une dimension
 *
 * @ORM\Entity()
 */
class Fourniture1D extends Fourniture
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
	 * @var float
	 *
	 * @ORM\Column(type="float")
	 */
	private $longueur;
	
	public function getForm(){
		return new FournitureType();
	}
	
	public function getTaille(){
		return $this->getLongueur().' [m]';
	}
	
	public function CalculQuantiteTotale(){
		return 'lon. : '.$this->getQuantite() * $this->getLongueur() . '[m]';
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
     * Set longueur
     *
     * @param float $longueur
     * @return Fourniture1D
     */
    public function setLongueur($longueur)
    {
        $this->longueur = $longueur;
    
        return $this;
    }

    /**
     * Get longueur
     *
     * @return float 
     */
    public function getLongueur()
    {
        return $this->longueur;
    }
}
