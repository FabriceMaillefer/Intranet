<?php

namespace FMR\FactureBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Facture
 * 
 * @author Fabrice Maillefer <fabrice.maillefer@gmail.com>
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
     * @ORM\JoinColumn(name="client_id", referencedColumnName="id", nullable=false)
     */
    private $client;

    /**
     * @var FMR\ChantierBundle\Entity\Chantier
     *
     * @ORM\OneToOne(targetEntity="FMR\ChantierBundle\Entity\Chantier", inversedBy="facture")
     * @ORM\JoinColumn(name="chantier_id", referencedColumnName="id", nullable=true)
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
     * @ORM\Column(name="DateImpression", type="datetime", nullable=true)
     */
    private $dateImpression;
    
    /**
     * @var \DateTime
     * 
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $datePayement;

    /**
     * @var FMR\FactureBundle\Entity\ArticleFacture
     *
     * @ORM\OneToMany(targetEntity="FMR\FactureBundle\Entity\ArticleFacture", mappedBy="facture", cascade={"persist", "remove"})
     * @ORM\OrderBy({"ordre" = "ASC"})
     */
    private $articles;

    /**
     * @var string
     * 
     * @ORM\Column(name="ReferenceClient", type="string", length=255, nullable=true)
     */
    private $referenceClient;

    /**
     * @var FMR\FactureBundle\Entity\StatutFacture
     *
     * @ORM\ManyToOne(targetEntity="FMR\FactureBundle\Entity\StatutFacture")
     * @ORM\JoinColumn(name="statut_id", referencedColumnName="id", nullable=false)
     */
    private $statut;

    /**
     * @var float
     * @Assert\Type(type="float", message="La valeur {{ value }} n'est pas un type {{ type }} valide.")
     * @ORM\Column(name="Rabais", type="float", nullable=true)
     */
    private $rabais;

    /**
     * @var float
     * @Assert\Type(type="float", message="La valeur {{ value }} n'est pas un type {{ type }} valide.")
     * @ORM\Column(name="TVA", type="float", nullable=true)
     */
    private $tVA;

    public function __construct() {
    	$this->dateCreation = new \DateTime();
    	$this->rabais = 0;
    	$this->tVA = 0.08;
    }
    
    public function __toString() {
    	return 'N°'.$this->id.': '.$this->getClient()->getNomPrenom().', '.$this->getReferenceClient();
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
     * Calcul du montant total de tous les articles
     *
     * @return float
     */
    public function CalculSommeTotale() {
    	$somme = 0;
    	foreach ($this->getArticles() as $article){
    		$somme += $article->CalculPrixTotal();
    	}
    	return $somme;
    }
    /**
     * Calcul du montant avec la TVA de la facture
     *
     * @return float
     */
    public function CalculSommeTTCTotale() {
    	return $this->arrondiAuCentime($this->CalculSommeTotale() + $this->CalculTVA());
    }
    
    /**
     * Calcul du montant avec la TVA et le rabais de la facture
     *
     * @return float
     */
    public function CalculSommeMontantTotal() {
    	return $this->arrondiAuCentime($this->CalculSommeTotale() + $this->CalculTVA() - $this->CalculRabais());
    }
    
    /**
     * Calcul du montant arrondi de la facture
     *
     * @return float
     */
    public function CalculSommeMontantArrondiTotal() {
    	return floor($this->CalculSommeMontantTotal());
    }
    
    /**
     * Calcul de la TVA de la facture
     *
     * @return float
     */
    public function CalculTVA() {
    	return $this->arrondiAuCentime($this->CalculSommeTotale() * $this->tVA);
    }
    
    /**
     * Calcul du rabais de la facture
     *
     * @return float
     */
    public function CalculRabais() {
    	return $this->arrondiAuCentime($this->CalculSommeTotale() * $this->rabais);
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
     * Set datePayement
     *
     * @param \DateTime $datePayement
     * @return Facture
     */
    public function setDatePayement($datePayement)
    {
    	$this->datePayement = $datePayement;
    
    	return $this;
    }
    
    /**
     * Get datePayement
     *
     * @return \DateTime
     */
    public function getDatePayement()
    {
    	return $this->datePayement;
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

    /**
     * Set client
     *
     * @param \FMR\ClientBundle\Entity\Client $client
     * @return Facture
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

    /**
     * Add articles
     *
     * @param \FMR\FactureBundle\Entity\ArticleFacture $articles
     * @return Facture
     */
    public function addArticle(\FMR\FactureBundle\Entity\ArticleFacture $articles)
    {
        $this->articles[] = $articles;
    
        return $this;
    }

    /**
     * Remove articles
     *
     * @param \FMR\FactureBundle\Entity\ArticleFacture $articles
     */
    public function removeArticle(\FMR\FactureBundle\Entity\ArticleFacture $articles)
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
     * @param \FMR\FactureBundle\Entity\StatutFacture $statut
     * @return Facture
     */
    public function setStatut(\FMR\FactureBundle\Entity\StatutFacture $statut = null)
    {
        $this->statut = $statut;
    
        return $this;
    }

    /**
     * Get statut
     *
     * @return \FMR\FactureBundle\Entity\StatutFacture 
     */
    public function getStatut()
    {
        return $this->statut;
    }
}
