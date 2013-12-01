<?php

namespace FMR\RelationClientBundle\Entity\Document;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use FMR\RelationClientBundle\Entity\RelationClientAvecLigne;
use FMR\RelationClientBundle\Form\DocumentType;

/**
 * Entité Document
 *
 * @author Fabrice Maillefer <fabrice.maillefer@gmail.com>
 * 
 * @ORM\Table()
 * @ORM\Entity()
 */
abstract class Document extends RelationClientAvecLigne
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
     * @var \DateTime
     *
     * @ORM\Column(name="DateImpression", type="datetime", nullable=true)
     */
    private $dateImpression;
    
    /**
     * @var string
     *
     * @ORM\Column(name="ReferenceClient", type="string", length=255, nullable=true)
     */
    private $referenceClient;
    
    /**
     * @var FMR\RelationClientBundle\Entity\StatutDocument
     *
     * @ORM\ManyToOne(targetEntity="FMR\RelationClientBundle\Entity\StatutDocument")
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
    private $tva;
    
    public function getRoute() { return 'document';}

    public function getids($mot=''){ return 'document';}
    public function getidsm($mot=''){ return 'Document';}
    public function getidp($mot=''){ return 'documents';}
    public function getidpi($mot=''){ return 'des '.$mot.'documents';}
    public function getidsi($mot=''){ return 'un '.$mot.'document';}
    public function getidsd($mot=''){ return 'le '.$mot.'document';}
    public function getidpd($mot=''){ return 'les '.$mot.'documents';}
    
    public function getForm(){
    	return new DocumentType();
    }

    
    public function isEditable(){
    	if (is_object($this->getStatut()))
    		return $this->getStatut()->isModifiable();
    	else 
    		return false;
    }
    
    /*
     * Methodes magiques
     */
    
    public function __construct() {
    	parent::__construct();
    	$this->rabais = 0;
    	$this->tva = 0.08;
    }
    
    public function __toString() {
    	return 'N°'.$this->id.': '.$this->getClient()->getNomPrenom().', '.$this->getReferenceClient();
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
     * @param float $TVA
     * @return Facture
     */
    public function setTva($tva)
    {
    	$this->tva = $tva;
    
    	return $this;
    }
    
    /**
     * Get TVA
     *
     * @return float
     */
    public function getTva()
    {
    	return $this->tva;
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
     * Calcul de la TVA de la facture
     *
     * @return float
     */
    public function CalculTVA() {
    	return $this->arrondiAuCentime($this->CalculSommeTotale() * $this->tva);
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
     * Calcul du montant total de toutes les listes de lignes
     *
     * @return float
     */
    public function CalculSommeTotale() {
    	$somme = 0;
    	foreach ($this->getLignes() as $ligne){
    		$somme += $ligne->CalculPrix();
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
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set dateImpression
     *
     * @param \DateTime $dateImpression
     * @return Document
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
     * Set statut
     *
     * @param \FMR\RelationClientBundle\Entity\StatutDocument $statut
     * @return Document
     */
    public function setStatut(\FMR\RelationClientBundle\Entity\StatutDocument $statut)
    {
        $this->statut = $statut;
    
        return $this;
    }

    /**
     * Get statut
     *
     * @return \FMR\RelationClientBundle\Entity\StatutDocument 
     */
    public function getStatut()
    {
        return $this->statut;
    }
}