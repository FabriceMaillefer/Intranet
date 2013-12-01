<?php

namespace FMR\LignesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use FMR\LignesBundle\Form\ArticleType;

/**
 * Entité Ligne
 *
 * @author Fabrice Maillefer <fabrice.maillefer@gmail.com>
 *
 * @ORM\Table()
 * @ORM\Entity()
 */
class Article extends Ligne
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
     * @Assert\NotBlank(message="La description ne doit pas être vide")
     * @ORM\Column(name="Descriptif", type="string", length=255)
     */
    private $descriptif;

    /**
     * @var float
     * @Assert\NotBlank()
     * @Assert\Type(type="float", message="La valeur {{ value }} n'est pas un type {{ type }} valide.")
     * @ORM\Column(name="Quantite", type="float")
     */
    private $quantite;

    /**
     * @var string
     * @Assert\NotBlank()
     * @ORM\Column(name="Unite", type="string", length=255)
     */
    private $unite;

    /**
     * @var float
     * @Assert\NotBlank()
     * @Assert\Type(type="float", message="La valeur {{ value }} n'est pas un type {{ type }} valide.")
     * @ORM\Column(name="PrixUnitaire", type="float")
     */
    private $prixUnitaire;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="Date", type="date")
     */
    private $date;

    
    /*
     * Methode magique
     */

    public function __construct() {
    	parent::__construct();
    	$this->quantite = 1;
    	$this->date = new \DateTime();
    	$this->prixUnitaire = 0;
    }

    /**
     * Retourne le formulaire correspondant au type d'article
     *
     * @return FournitureType
     */
    public function getForm(){
    	return new ArticleType($this->id);
    }
    
    public function getLabelAjout(){
    	return "Ajouter un article";
    }

    /**
     * écrit la taille
     *
     * @return string
     */
    public function getTaille(){
    	return '';
    }
    
    public function getLibelle(){
    	return $this->getDescriptif(). ' '.$this->getTaille();
    }
    
    
    /**
     * Calcul de la quantité totale de l'objet
     *
     * @return float
     */
    public function CalculQuantiteTotale(){
    	return $this->quantite;
    }
    
    /**
     * calcul du prix
     *
     * @return string
     */
    public function CalculPrix(){
    	return $this->CalculQuantiteTotale() * $this->getPrixUnitaire();
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
     * Set descriptif
     *
     * @param string $descriptif
     * @return Article
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
     * @return Article
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
     * Set unite
     *
     * @param string $unite
     * @return Article
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
     * Set prixUnitaire
     *
     * @param float $prixUnitaire
     * @return Article
     */
    public function setPrixUnitaire($prixUnitaire)
    {
        $this->prixUnitaire = $prixUnitaire;
    
        return $this;
    }

    /**
     * Get prixUnitaire
     *
     * @return float 
     */
    public function getPrixUnitaire()
    {
        return $this->prixUnitaire;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     * @return Article
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
}