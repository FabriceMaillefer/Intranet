<?php

namespace FMR\ClientBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Client
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="FMR\ClientBundle\Entity\ClientRepository")
 */
class Client
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
     * @var string
     *
     * @ORM\Column(name="Nom", type="string", length=255)
     */
    private $nom;

    /**
     * @var string
     *
     * @ORM\Column(name="Prenom", type="string", length=255)
     */
    private $prenom;

    /**
     * @var string
     *
     * @ORM\Column(name="Adresse", type="string", length=255)
     */
    private $adresse;

    /**
     * @var integer
     *
     * @ORM\Column(name="NPA", type="integer")
     */
    private $nPA;

    /**
     * @var string
     *
     * @ORM\Column(name="Localite", type="string", length=255)
     */
    private $localite;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="DateCreation", type="datetime")
     */
    private $dateCreation;

    /**
     * @var string
     *
     * @ORM\Column(name="Divers", type="string", length=255)
     */
    private $divers;

    /**
     * @var string
     *
     * @ORM\Column(name="Email", type="string", length=255)
     */
    private $email;

    /**
     * @var FMR\OffreBundle\Entity\Offre
     *
	 * @ORM\OneToMany(targetEntity="FMR\OffreBundle\Entity\Offre", mappedBy="client")
	 * 
     */
    private $offres;

    /**
     * @var FMR\ChantierBundle\Entity\Chantier
     *
     * @ORM\OneToMany(targetEntity="FMR\ChantierBundle\Entity\Chantier", mappedBy="client")
     */
    private $chantiers;

    /**
     * @var \stdClass
     *
     * @ORM\OneToMany(targetEntity="FMR\FactureBundle\Entity\Facture", mappedBy="client")
     */
    private $factures;

    public function __construct() {
    	$this->dateCreation = new \DateTime();
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
     * Set nom
     *
     * @param string $nom
     * @return Client
     */
    public function setNom($nom)
    {
        $this->nom = $nom;
    
        return $this;
    }

    /**
     * Get nom
     *
     * @return string 
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * Set prenom
     *
     * @param string $prenom
     * @return Client
     */
    public function setPrenom($prenom)
    {
        $this->prenom = $prenom;
    
        return $this;
    }

    /**
     * Get prenom
     *
     * @return string 
     */
    public function getPrenom()
    {
        return $this->prenom;
    }

    /**
     * Set adresse
     *
     * @param string $adresse
     * @return Client
     */
    public function setAdresse($adresse)
    {
        $this->adresse = $adresse;
    
        return $this;
    }

    /**
     * Get adresse
     *
     * @return string 
     */
    public function getAdresse()
    {
        return $this->adresse;
    }

    /**
     * Set nPA
     *
     * @param integer $nPA
     * @return Client
     */
    public function setNPA($nPA)
    {
        $this->nPA = $nPA;
    
        return $this;
    }

    /**
     * Get nPA
     *
     * @return integer 
     */
    public function getNPA()
    {
        return $this->nPA;
    }

    /**
     * Set localite
     *
     * @param string $localite
     * @return Client
     */
    public function setLocalite($localite)
    {
        $this->localite = $localite;
    
        return $this;
    }

    /**
     * Get localite
     *
     * @return string 
     */
    public function getLocalite()
    {
        return $this->localite;
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
     * Set divers
     *
     * @param string $divers
     * @return Client
     */
    public function setDivers($divers)
    {
        $this->divers = $divers;
    
        return $this;
    }

    /**
     * Get divers
     *
     * @return string 
     */
    public function getDivers()
    {
        return $this->divers;
    }

    /**
     * Set email
     *
     * @param string $email
     * @return Client
     */
    public function setEmail($email)
    {
        $this->email = $email;
    
        return $this;
    }

    /**
     * Get email
     *
     * @return string 
     */
    public function getEmail()
    {
        return $this->email;
    }


}
