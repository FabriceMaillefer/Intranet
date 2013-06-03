<?php

namespace FMR\CommonBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Article de base
 *
 * @ORM\Table()
 * @ORM\Entity
 * @ORM\InheritanceType("JOINED")
 * @ORM\DiscriminatorColumn(name="type_class", type="string")
 */
class ArticleBase
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
     * @var integer
     *
     * @ORM\Column(name="Ordre", type="integer")
     */
    private $ordre;

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
     * @ORM\Column(name="DateCreation", type="datetime")
     */
    private $dateCreation;

    public function __construct() {
    	$this->dateCreation = new \DateTime();
    	$this->ordre  = 0;
    	$this->quantite = 1;
    	$this->prixUnitaire = 0;
    }
    
    /**
     * Arrondi au 5 centimes
     * 
     * @var float
     * @return float
     */
    public function arrondiAuCentime($montant){
    	return 0.05 * ceil($montant / 0.05);
    }

    /**
     * Calcul du prix total
     *
     * @return float
     */
    public function CalculPrixTotal()
    {
    	return $this->arrondiAuCentime($this->prixUnitaire * $this->quantite);
 
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
     * Set ordre
     *
     * @param integer $ordre
     * @return Article
     */
    public function setOrdre($ordre)
    {
        $this->ordre = $ordre;
    
        return $this;
    }

    /**
     * Get ordre
     *
     * @return integer 
     */
    public function getOrdre()
    {
        return $this->ordre;
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
     * Get dateCreation
     *
     * @return \DateTime
     */
    public function getDateCreation()
    {
    	return $this->dateCreation;
    }
}

