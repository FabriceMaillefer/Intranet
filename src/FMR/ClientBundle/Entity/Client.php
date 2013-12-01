<?php

namespace FMR\ClientBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Entité Client
 *
 * @author Fabrice Maillefer <fabrice.maillefer@gmail.com>
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="FMR\ClientBundle\Entity\ClientRepository")
 */
class Client
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
    private $id;

    /**
     * @var string
     * @Assert\NotBlank(message="Le nom ne doit pas être vide")
     * @ORM\Column(name="Nom", type="string", length=255)
     */
    private $nom;

    /**
     * @var string
     * @Assert\NotBlank(message="Le prénom ne doit pas être vide")
     * @ORM\Column(name="Prenom", type="string", length=255)
     */
    private $prenom;

    /**
     * @var string
     *
     * @ORM\Column(name="Adresse", type="string", length=255, nullable=true)
     */
    private $adresse;

    /**
     * @var integer
     *
     * @ORM\Column(name="NPA", type="integer", nullable=true)
     */
    private $nPA;

    /**
     * @var string
     *
     * @ORM\Column(name="Localite", type="string", length=255, nullable=true)
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
     * @ORM\Column(name="Divers", type="string", length=255, nullable=true)
     */
    private $divers;

    /**
     * @var string
     *
     * @ORM\Column(name="Email", type="string", length=255, nullable=true)
     */
    private $email;
    
    /**
     * @var string
     *
     * @ORM\Column(name="Tel", type="string", length=255, nullable=true)
     */
    private $tel;

    /**
     *
     *
	 * @ORM\OneToMany(targetEntity="FMR\RelationClientBundle\Entity\RelationClient", mappedBy="client")
	 * 
     */
    private $relationClient;


    /*
     * Methodes magiques
     */
    
    public function __construct() {
    	$this->dateCreation = new \DateTime();
    }
    public function __toString() {
    	return $this->getNomPrenom();
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
     * Get nom et pr�nom
     *
     * @return string
     */
    public function getNomPrenom()
    {
    	return $this->nom .' '. $this->prenom;
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



    /**
     * Set dateCreation
     *
     * @param \DateTime $dateCreation
     * @return Client
     */
    public function setDateCreation($dateCreation)
    {
        $this->dateCreation = $dateCreation;
    
        return $this;
    }

    

    /**
     * Set tel
     *
     * @param string $tel
     * @return Client
     */
    public function setTel($tel)
    {
        $this->tel = $tel;
    
        return $this;
    }

    /**
     * Get tel
     *
     * @return string 
     */
    public function getTel()
    {
        return $this->tel;
    }

    /**
     * Add relationClient
     *
     * @param \FMR\RelationClientBundle\Entity\RelationClient $relationClient
     * @return Client
     */
    public function addRelationClient(\FMR\RelationClientBundle\Entity\RelationClient $relationClient)
    {
        $this->relationClient[] = $relationClient;
    
        return $this;
    }

    /**
     * Remove relationClient
     *
     * @param \FMR\RelationClientBundle\Entity\RelationClient $relationClient
     */
    public function removeRelationClient(\FMR\RelationClientBundle\Entity\RelationClient $relationClient)
    {
        $this->relationClient->removeElement($relationClient);
    }

    /**
     * Get relationClient
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getRelationClient()
    {
        return $this->relationClient;
    }
}