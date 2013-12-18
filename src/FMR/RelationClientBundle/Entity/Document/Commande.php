<?php

namespace FMR\RelationClientBundle\Entity\Document;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use FMR\RelationClientBundle\Entity\Document\Document;

/**
 * Commande
 * 
 * @author Fabrice Maillefer <fabrice.maillefer@gmail.com>
 * 
 * @ORM\Table()
 * @ORM\Entity
 */
class Commande extends Document
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    public function getids($mot=''){ return 'commande';}
    public function getidsm($mot=''){ return 'Commande';}
    public function getidp($mot=''){ return 'commandes';}
    public function getidpm($mot=''){ return 'Commandes';}
    public function getidpi($mot=''){ return 'des '.$mot.'commandes';}
    public function getidsi($mot=''){ return 'une '.$mot.'commande';}
    public function getidsd($mot=''){ return 'la '.$mot.'commande';}
    public function getidpd($mot=''){return 'les '.$mot.'commandes';}

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