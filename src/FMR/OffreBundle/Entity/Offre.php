<?php

namespace FMR\OffreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Offre
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="FMR\OffreBundle\Entity\OffreRepository")
 */
class Offre
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
     * @ORM\ManyToOne(targetEntity="FMR\ClientBundle\Entity\Client", inversedBy="offres")
     * @ORM\JoinColumn(name="client_id", referencedColumnName="id", nullable=false)
     */
    private $client;

    /**
     * @var FMR\ChantierBundle\Entity\Chantier
     *
     * @ORM\OneToOne(targetEntity="FMR\ChantierBundle\Entity\Chantier", mappedBy="offre")
     */
    private $chantier;
    
    
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="DateCreation", type="datetime")
     */
    private $dateCreation;

    /**
     * @var FMR\OffreBundle\Entity\Article
     *
     * @ORM\OneToMany(targetEntity="FMR\OffreBundle\Entity\ArticleOffre", mappedBy="offre")
     */
    private $articles;

    /**
     * @var string
     *
     * @ORM\Column(name="ReferenceClient", type="string", length=255, nullable=true)
     */
    private $referenceClient;

    /**
     * @var FMR\OffreBundle\Entity\StatutOffre
     *
     * @ORM\ManyToOne(targetEntity="FMR\OffreBundle\Entity\StatutOffre")
     * @ORM\JoinColumn(name="statut_id", referencedColumnName="id", nullable=false)
     */
    private $statut;

    public function __construct() {
    	$this->dateCreation = new \DateTime();
    }
    public function __toString() {
    	return 'N°'.$this->id.': '.$this->getClient()->getNomPrenom().', '.$this->getReferenceClient();
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
	 * Verifie si le statut permet la modification de l'entité. 
	 * Statut 1 = En création
     */
    public function isEditable()
    {
    	if($this->getStatut()->getId() == 1){
    		return true;
    	} else {
    		return false;
    	}
    		
    	
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
     * Set referenceClient
     *
     * @param string $referenceClient
     * @return Offre
     */
    public function setReferenceClient($referenceClient)
    {
        $this->referenceClient = $referenceClient;
    
        return $this;
    }

    /**
     * Get referenceClient
     *
     * @return string 
     */
    public function getReferenceClient()
    {
        return $this->referenceClient;
    }



    /**
     * Set dateCreation
     *
     * @param \DateTime $dateCreation
     * @return Offre
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
     * @return Offre
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
     * Add articles
     *
     * @param \FMR\OffreBundle\Entity\ArticleOffre $articles
     * @return Offre
     */
    public function addArticle(\FMR\OffreBundle\Entity\ArticleOffre $articles)
    {
        $this->articles[] = $articles;
    
        return $this;
    }

    /**
     * Remove articles
     *
     * @param \FMR\OffreBundle\Entity\ArticleOffre $articles
     */
    public function removeArticle(\FMR\OffreBundle\Entity\ArticleOffre $articles)
    {
        $this->articles->removeElement($articles);
    }

    /**
     * Get articles
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getArticles()
    {
        return $this->articles;
    }

    /**
     * Set statut
     *
     * @param \FMR\OffreBundle\Entity\StatutOffre $statut
     * @return Offre
     */
    public function setStatut(\FMR\OffreBundle\Entity\StatutOffre $statut = null)
    {
        $this->statut = $statut;
    
        return $this;
    }

    /**
     * Get statut
     *
     * @return \FMR\OffreBundle\Entity\StatutOffre 
     */
    public function getStatut()
    {
        return $this->statut;
    }
    
    /**
     * Set chantier
     *
     * @param \FMR\ChantierBundle\Entity\Chantier $chantier
     * @return Facture
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
