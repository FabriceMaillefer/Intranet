<?php

namespace FMR\FactureBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Facture
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="FMR\FactureBundle\Entity\FactureRepository")
 */
class Facture
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
     * @ORM\ManyToOne(targetEntity="FMR\ClientBundle\Entity\Client", inversedBy="factures")
     */
    private $client;

    /**
     * @var FMR\ChantierBundle\Entity\Chantier
     *
     * @ORM\OneToOne(targetEntity="FMR\ChantierBundle\Entity\Chantier")
     */
    private $chantier;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="DateCreation", type="datetime")
     */
    private $dateCreation;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="DateImpression", type="datetime")
     */
    private $dateImpression;

    /**
     * @var FMR\OffreBundle\Entity\Article
     *
     * @ORM\OneToMany(targetEntity="FMR\FactureBundle\Entity\ArticleFacture", mappedBy="facture")
     */
    private $articles;

    /**
     * @var string
     *
     * @ORM\Column(name="ReferenceClient", type="string", length=255)
     */
    private $referenceClient;

    /**
     * @var FMR\FactureBundle\Entity\StatutFacture
     *
     * @ORM\ManyToOne(targetEntity="FMR\FactureBundle\Entity\StatutFacture")
     */
    private $statut;

    /**
     * @var float
     *
     * @ORM\Column(name="Rabais", type="float")
     */
    private $rabais;

    /**
     * @var float
     *
     * @ORM\Column(name="TVA", type="float")
     */
    private $tVA;

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
     * Get dateCreation
     *
     * @return \DateTime 
     */
    public function getDateCreation()
    {
        return $this->dateCreation;
    }

    /**
     * Set dateImpression
     *
     * @param \DateTime $dateImpression
     * @return Facture
     */
    public function setDateImpression($dateImpression)
    {
        $this->dateImpression = $dateImpression;
    
        return $this;
    }

    /**
     * Get dateImpression
     *
     * @return \DateTime 
     */
    public function getDateImpression()
    {
        return $this->dateImpression;
    }



    /**
     * Set referenceClient
     *
     * @param string $referenceClient
     * @return Facture
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
     * Set rabais
     *
     * @param float $rabais
     * @return Facture
     */
    public function setRabais($rabais)
    {
        $this->rabais = $rabais;
    
        return $this;
    }

    /**
     * Get rabais
     *
     * @return float 
     */
    public function getRabais()
    {
        return $this->rabais;
    }

    /**
     * Set tVA
     *
     * @param float $tVA
     * @return Facture
     */
    public function setTVA($tVA)
    {
        $this->tVA = $tVA;
    
        return $this;
    }

    /**
     * Get tVA
     *
     * @return float 
     */
    public function getTVA()
    {
        return $this->tVA;
    }
}
