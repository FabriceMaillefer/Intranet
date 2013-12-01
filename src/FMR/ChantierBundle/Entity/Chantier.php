<?php

namespace FMR\ChantierBundle\Entity;

use FMR\RelationClientBundle\Entity;
use Doctrine\ORM\Mapping as ORM;
use FMR\RelationClientBundle\Entity\RelationClientAvecLigne;
/**
 * Entité Chantier
 *
 * @author Fabrice Maillefer <fabrice.maillefer@gmail.com>
 *
 * @ORM\Table()
 * @ORM\Entity
 * ORM\Entity(repositoryClass="FMR\ChantierBundle\Entity\ChantierRepository")
 */
class Chantier extends RelationClientAvecLigne
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
    protected  $id;

    /**
     * @var string
     *
     * @ORM\Column(name="Architecte", type="string", length=255, nullable=true)
     */
    private $architecte;

    /**
     * @var string
     * 
     * @ORM\Column(name="Lieu", type="string", length=255, nullable=true)
     */
    private $lieu;


    /**
     * @var string
     *
     * @ORM\Column(name="Description", type="string", length=255, nullable=true)
     */
    private $description;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="DateDebut", type="date", nullable=true)
     */
    private $dateDebut;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="DateFin", type="date", nullable=true)
     */
    private $dateFin;


    /*
     * Methodes magiques
     */
    
    public function __construct() {
    	parent::__construct();
    	$this->dateDebut = new \DateTime();
    }

    public function __toString() {
    	//return 'N°'.$this->id.': '.$this->getClient()->getNomPrenom().' à '.$this->getLieu();
    	return 'N°'.$this->id.':  à '.$this->getLieu();
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
     * Set architecte
     *
     * @param string $architecte
     * @return Chantier
     */
    public function setArchitecte($architecte)
    {
        $this->architecte = $architecte;
    
        return $this;
    }

    /**
     * Get architecte
     *
     * @return string 
     */
    public function getArchitecte()
    {
        return $this->architecte;
    }

    /**
     * Set lieu
     *
     * @param string $lieu
     * @return Chantier
     */
    public function setLieu($lieu)
    {
        $this->lieu = $lieu;
    
        return $this;
    }

    /**
     * Get lieu
     *
     * @return string 
     */
    public function getLieu()
    {
        return $this->lieu;
    }

    

    /**
     * Set description
     *
     * @param string $description
     * @return Chantier
     */
    public function setDescription($description)
    {
        $this->description = $description;
    
        return $this;
    }

    /**
     * Get description
     *
     * @return string 
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set dateDebut
     *
     * @param \DateTime $dateDebut
     * @return Chantier
     */
    public function setDateDebut($dateDebut)
    {
        $this->dateDebut = $dateDebut;
    
        return $this;
    }

    /**
     * Get dateDebut
     *
     * @return \DateTime 
     */
    public function getDateDebut()
    {
        return $this->dateDebut;
    }

    /**
     * Set dateFin
     *
     * @param \DateTime $dateFin
     * @return Chantier
     */
    public function setDateFin($dateFin)
    {
        $this->dateFin = $dateFin;
    
        return $this;
    }

    /**
     * Get dateFin
     *
     * @return \DateTime 
     */
    public function getDateFin()
    {
        return $this->dateFin;
    }


   
}