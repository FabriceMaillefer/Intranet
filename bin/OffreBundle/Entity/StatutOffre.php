<?php

namespace FMR\OffreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * StatutOffre
 *
 * @author Fabrice Maillefer <fabrice.maillefer@gmail.com>
 * 
 * @ORM\Table()
 * @ORM\Entity
 */
class StatutOffre
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
     * @ORM\Column(name="Statut", type="string", length=255)
     */
    private $statut;

    public function __toString(){
    	return $this->statut;
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
     * Set statut
     *
     * @param string $statut
     * @return StatutOffre
     */
    public function setStatut($statut)
    {
        $this->statut = $statut;
    
        return $this;
    }

    /**
     * Get statut
     *
     * @return string 
     */
    public function getStatut()
    {
        return $this->statut;
    }
}
