<?php

namespace FMR\RelationClientBundle\Entity\Document;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use FMR\RelationClientBundle\Entity\Document\Document;

/**
 * Offre
 * 
 * @author Fabrice Maillefer <fabrice.maillefer@gmail.com>
 * 
 * @ORM\Table()
 * @ORM\Entity
 */
class Offre extends Document
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    public function getids($mot=''){ return 'offre';}
    public function getidsm($mot=''){ return 'Offre';}
    public function getidp($mot=''){ return 'offres';}
    public function getidpm($mot=''){ return 'Offres';}
    public function getidpi($mot=''){ return 'des '.$mot.'offres';}
    public function getidsi($mot=''){ return 'une '.$mot.'offre';}
    public function getidsd($mot=''){ return 'l\''.$mot.'offre';}
    public function getidpd($mot=''){return 'les '.$mot.'offres';}

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