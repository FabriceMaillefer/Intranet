<?php

namespace FMR\ChantierBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Chantier
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="FMR\ChantierBundle\Entity\ChantierRepository")
 */
class Chantier
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var FMR\ClientBundle\Entity\Client
     *
     * @ORM\ManyToOne(targetEntity="FMR\ClientBundle\Entity\Client", inversedBy="chantiers")
     * @ORM\JoinColumn(name="client_id", referencedColumnName="id", nullable=false)
     */
    private $client;

    /**
     * @var FMR\OffreBundle\Entity\Offre
     *
     * @ORM\OneToOne(targetEntity="FMR\OffreBundle\Entity\Offre", inversedBy="chantier")
     * @ORM\JoinColumn(name="offre_id", referencedColumnName="id", nullable=true)
     */
    private $offre;

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
     * @var FMR\OffreBundle\Entity\Fourniture
     *
     * @ORM\OneToMany(targetEntity="FMR\ChantierBundle\Entity\Fourniture", mappedBy="chantier")
     */
    private $fournitures;

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

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="DateCreation", type="datetime")
     */
    private $dateCreation;

    public function __construct() {
    	$this->dateCreation = new \DateTime();
    	$this->dateDebut = new \DateTime();
    }

    public function __toString() {
    	return 'N°'.$this->id.': '.$this->getClient()->getNomPrenom().' à '.$this->getLieu();
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
     * Set dateCreation
     *
     * @param \DateTime $dateCreation
     * @return Chantier
     */
    public function setDateCreation($dateCreation)
    {
        $this->dateCreation = $dateCreation;
    
        return $this;
    }

    /**
     * Set client
     *
     * @param \FMR\ClientBundle\Entity\Client $client
     * @return Chantier
     */
    public function setClient(\FMR\ClientBundle\Entity\Client $client = null)
    {
        $this->client = $client;
    
        return $this;
    }

    /**
     * Get client
     *
     * @return \FMR\ClientBundle\Entity\Client 
     */
    public function getClient()
    {
        return $this->client;
    }

    /**
     * Set offre
     *
     * @param \FMR\OffreBundle\Entity\Offre $offre
     * @return Chantier
     */
    public function setOffre(\FMR\OffreBundle\Entity\Offre $offre = null)
    {
        $this->offre = $offre;
    
        return $this;
    }

    /**
     * Get offre
     *
     * @return \FMR\OffreBundle\Entity\Offre 
     */
    public function getOffre()
    {
        return $this->offre;
    }

    /**
     * Add fournitures
     *
     * @param \FMR\ChantierBundle\Entity\Fourniture $fournitures
     * @return Chantier
     */
    public function addFourniture(\FMR\ChantierBundle\Entity\Fourniture $fournitures)
    {
        $this->fournitures[] = $fournitures;
    
        return $this;
    }

    /**
     * Remove fournitures
     *
     * @param \FMR\ChantierBundle\Entity\Fourniture $fournitures
     */
    public function removeFourniture(\FMR\ChantierBundle\Entity\Fourniture $fournitures)
    {
        $this->fournitures->removeElement($fournitures);
    }

    /**
     * Get fournitures
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getFournitures()
    {
        return $this->fournitures;
    }
}
