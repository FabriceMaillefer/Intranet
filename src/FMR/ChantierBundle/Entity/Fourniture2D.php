<?php


namespace FMR\ChantierBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use FMR\ChantierBundle\Form\Fourniture2DType as FournitureType;

/**
 * Fourniture deux dimensions 
 *
 * @ORM\Entity()
 */
class Fourniture2D extends Fourniture1D
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
	private $largeur;
	
	public function getForm(){
		return new FournitureType();
	}
	
	public function getTaille(){
		return $this->getLongueur().' [m] x '.$this->getLargeur().' [cm]';
	}
	
	public function CalculQuantiteTotale(){
		return $this->getQuantite() * $this->getLongueur() * $this->getLargeur()/100;
	}

	public function __construct(){
		parent::__construct();
		$this->setUnite('m2');
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
     * Set largeur
     *
     * @param float $largeur
     * @return Fourniture2D
     */
    public function setLargeur($largeur)
    {
        $this->largeur = $largeur;
    
        return $this;
    }

    /**
     * Get largeur
     *
     * @return float 
     */
    public function getLargeur()
    {
        return $this->largeur;
    }
}
