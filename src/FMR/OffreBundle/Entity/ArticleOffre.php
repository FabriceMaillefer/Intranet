<?php

namespace FMR\OffreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use FMR\CommonBundle\Entity\ArticleBase;

/**
 * ArticleOffre
 *
 * @author Fabrice Maillefer <fabrice.maillefer@gmail.com>
 * 
 * @ORM\Table()
 * @ORM\Entity()
 */
class ArticleOffre extends ArticleBase
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
	 * @var FMR\OffreBundle\Entity\Offre
	 *
	 * @ORM\ManyToOne(targetEntity="FMR\OffreBundle\Entity\Offre", inversedBy="articles")
	 */
	private $offre;

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
     * Set offre
     *
     * @param \FMR\OffreBundle\Entity\Offre $offre
     * @return ArticleOffre
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
}
