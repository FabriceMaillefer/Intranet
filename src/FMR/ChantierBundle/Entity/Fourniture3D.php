<?php

namespace FMR\ChantierBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use FMR\ChantierBundle\Form\Fourniture3DType as FournitureType;

/**
 * Entité Fourniture trois dimensions 
 *
 * @author Fabrice Maillefer <fabrice.maillefer@gmail.com>
 *
 * @ORM\Entity()
 */
class Fourniture3D extends Fourniture2D
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
	 * @var float
	 *
	 * @ORM\Column(type="float")
	 */
	private $hauteur;
	
	/*
	 * Methode magique
	*/
	public function __construct(){
		parent::__construct();
		$this->setUnite('m3');
	}
	
	
	/*
	 * Methodes spéciales
	 */
	
	public function getForm(){
		return new FournitureType();
	}

	public function getTaille(){
		return $this->getLongueur().' [m] x '.$this->getLargeur().' [cm] x '.$this->getHauteur().' [mm]';
	}
	
	public function CalculQuantiteTotale(){
		return $this->getQuantite() * $this->getLongueur() * $this->getLargeur()/100 * $this->getHauteur()/1000;
	}
	
	/*
	 * Getter et Setter
	 */
	
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
     * Set hauteur
     *
     * @param float $hauteur
     * @return Fourniture3D
     */
    public function setHauteur($hauteur)
    {
        $this->hauteur = $hauteur;
    
        return $this;
    }

    /**
     * Get hauteur
     *
     * @return float 
     */
    public function getHauteur()
    {
        return $this->hauteur;
    }
}
