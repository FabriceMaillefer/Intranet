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
     */
    private $client;

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
     * @ORM\Column(name="ReferenceClient", type="string", length=255)
     */
    private $referenceClient;

    /**
     * @var FMR\OffreBundle\Entity\StatutOffre
     *
     * @ORM\ManyToOne(targetEntity="FMR\OffreBundle\Entity\StatutOffre")
     */
    private $statut;

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


}
