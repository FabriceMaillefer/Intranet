<?php

namespace FMR\LignesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use FMR\LignesBundle\Form\Article3DType;

/**
 * Entité Article trois dimensions 
 *
 * @author Fabrice Maillefer <fabrice.maillefer@gmail.com>
 *
 * @ORM\Entity()
 */
class Article3D extends Article2D
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
	
	public function getLabelAjout(){
		return "Ajouter un article 3D";
	}
	
	/*
	 * Methodes spéciales
	 */
	
	public function getForm(){
		return new Article3DType($this->id);
	}

	public function getTaille(){
		$taille = $this->getQuantite();
		$taille .= $this->getQuantite() == 1 ? 'pc' : 'pcs ';
		$taille .=	$this->getLongueur().' [m]x'.$this->getLargeur().' [cm]x'.$this->getHauteur().'[mm]';
		return  $taille;
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