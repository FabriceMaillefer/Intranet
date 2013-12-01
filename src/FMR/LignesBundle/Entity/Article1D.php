<?php

namespace FMR\LignesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use FMR\LignesBundle\Form\Article1DType;

/**
 * Entité Article une dimension
 *
 *	@author Fabrice Maillefer <fabrice.maillefer@gmail.com>
 *
 * @ORM\Entity()
 */
class Article1D extends Article
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
	private $longueur;
	
	/*
	 * Methode magique
	*/
	public function __construct(){
		parent::__construct();
		$this->setUnite('m');
	}
	
	public function getLabelAjout(){
		return "Ajouter un article 1D";
	}
	
	/*
	 * Methodes spéciales
	*/
	
	public function getForm(){
		return new Article1DType($this->id);
	}
	
	public function getTaille(){
		return $this->getLongueur().' [m]';
	}
	
	public function getLigneFacturation(){
		return  $this->getQuantite().'x '.$this->getDescriptif(). ' : '. $this->getTaille();
	}
	
	public function CalculQuantiteTotale(){
		return $this->getQuantite() * $this->getLongueur();
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