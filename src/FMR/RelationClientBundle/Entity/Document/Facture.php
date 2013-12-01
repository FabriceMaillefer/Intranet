<?php

namespace FMR\RelationClientBundle\Entity\Document;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use FMR\RelationClientBundle\Entity\Document\Document;
/**
 * Facture
 * 
 * @author Fabrice Maillefer <fabrice.maillefer@gmail.com>
 * 
 * @ORM\Table()
 * @ORM\Entity
 */
class Facture extends Document
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
     * @var \DateTime
     * 
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $datePayement;

    public function getids($mot=''){ return 'facture';}
    public function getidsm($mot=''){ return 'Facture';}
    public function getidp($mot=''){ return 'factures';}
    public function getidpi($mot=''){ return 'des '.$mot.'factures';}
    public function getidsi($mot=''){ return 'une '.$mot.'facture';}
    public function getidsd($mot=''){ return 'la '.$mot.'facture';}
    public function getidpd($mot=''){return 'les '.$mot.'factures';}
    
    

    
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
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }
}