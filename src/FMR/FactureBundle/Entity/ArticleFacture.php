<?php

namespace FMR\FactureBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use FMR\CommonBundle\Entity\ArticleBase;

/**
 * ArticleFacture
 *
 * @ORM\Table()
 * @ORM\Entity()
 */
class ArticleFacture extends ArticleBase
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
	 * @var FMR\FactureBundle\Entity\Facture
	 *
	 * @ORM\ManyToOne(targetEntity="FMR\FactureBundle\Entity\Facture", inversedBy="articles")
	 */
	private $facture;

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
     * Set facture
     *
     * @param \FMR\FactureBundle\Entity\Facture $facture
     * @return ArticleFacture
     */
    public function setFacture(\FMR\FactureBundle\Entity\Facture $facture = null)
    {
        $this->facture = $facture;
    
        return $this;
    }

    /**
     * Get facture
     *
     * @return \FMR\FactureBundle\Entity\Facture 
     */
    public function getFacture()
    {
        return $this->facture;
    }
}
