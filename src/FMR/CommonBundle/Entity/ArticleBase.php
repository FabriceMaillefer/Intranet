<?php

namespace FMR\CommonBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Article de base
 *
 * @ORM\Table()
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
     *
     * @ORM\Column(name="Descriptif", type="string", length=255)
     */
    private $descriptif;

    /**
     * @var float
     *
     * @ORM\Column(name="Quantite", type="float")
     */
    private $quantite;

    /**
     * @var string
     *
     * @ORM\Column(name="Unite", type="string", length=255)
     */
    private $unite;

    /**
     * @var float
     *
     * @ORM\Column(name="PrixUnitaire", type="float")
     */
    private $prixUnitaire;


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
}

