<?php

namespace FMR\ChantierBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use FMR\ChantierBundle\Form\FournitureType as FournitureType;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Entité Fourniture simple
 *
 * @author Fabrice Maillefer <fabrice.maillefer@gmail.com>
 *
 * @ORM\Entity()
 * @ORM\InheritanceType("JOINED")
 * @ORM\DiscriminatorColumn(name="type_class", type="string")
 */
class Fourniture
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
     * @var string
     * @Assert\NotBlank(message="Le descriptif ne doit pas être vide")
     * @ORM\Column(name="Descriptif", type="string", length=255)
     */
    private $descriptif;

    /**
     * @var float
     * @Assert\NotBlank()
     * @ORM\Column(name="Quantite", type="float")
     */
    private $quantite;

    /**
     * @var \DateTime
     * 
     * @ORM\Column(name="Date", type="date")
     */
    private $date;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="DateCreation", type="datetime")
     */
    private $dateCreation;



    /**
     * @var string
     * @Assert\NotBlank(message="l'unité ne doit pas être vide")
     * @ORM\Column(name="Unite", type="string", length=10)
     */
    private $unite;
    
    /*
     * Methode magique
     */

    public function __construct() {
    	$this->dateCreation = new \DateTime();
    	$this->date = new \DateTime();
    	$this->quantite = 1;
    	$this->unite = "pcs";
    }

    /*
     * Methodes spéciales
     */
    
    /**
     * Retourne le formulaire correspondant au type de fourniture
     *
     * @return FournitureType
     */
    public function getForm(){
    	return new FournitureType();
    }
    
    /**
     * écrit la taille
     * 
     * @return string
     */
	public function getTaille(){
		return '';
	}
	
	/**
	 * Texte utilisé pour créer les articles des factures
	 *
	 * @return string
	 */
	public function getLigneFacturation(){
		return  $this->getDescriptif();
	}
    
	/**
	 * Calcul de la quantité totale de l'objet
	 *
	 * @return float
	 */
	public function CalculQuantiteTotale(){
		return $this->quantite;
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
     * Set descriptif
     *
     * @param string $descriptif
     * @return Fourniture
     */
    public function setDescriptif($descriptif)
    {
        $this->descriptif = $descriptif;
    
        return $this;
    }

    /**
     * Get descriptif
     *
     * @return string 
     */
    public function getDescriptif()
    {
        return $this->descriptif;
    }

    /**
     * Set quantite
     *
     * @param float $quantite
     * @return Fourniture
     */
    public function setQuantite($quantite)
    {
        $this->quantite = $quantite;
    
        return $this;
    }

    /**
     * Get quantite
     *
     * @return float 
     */
    public function getQuantite()
    {
        return $this->quantite;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     * @return Fourniture
     */
    public function setDate($date)
    {
        $this->date = $date;
    
        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime 
     */
    public function getDate()
    {
        return $this->date;
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
     * Set unite
     *
     * @param string $unite
     * @return Fourniture
     */
    public function setUnite($unite)
    {
        $this->unite = $unite;
    
        return $this;
    }

    /**
     * Get unite
     *
     * @return string 
     */
    public function getUnite()
    {
        return $this->unite;
    }

    /**
     * Set dateCreation
     *
     * @param \DateTime $dateCreation
     * @return Fourniture
     */
    public function setDateCreation($dateCreation)
    {
        $this->dateCreation = $dateCreation;
    
        return $this;
    }

    /**
     * Set chantier
     *
     * @param \FMR\ChantierBundle\Entity\Chantier $chantier
     * @return Fourniture
     */
    public function setChantier(\FMR\ChantierBundle\Entity\Chantier $chantier = null)
    {
        $this->chantier = $chantier;
    
        return $this;
    }

    /**
     * Get chantier
     *
     * @return \FMR\ChantierBundle\Entity\Chantier 
     */
    public function getChantier()
    {
        return $this->chantier;
    }
}