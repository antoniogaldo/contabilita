<?php

namespace App\Entity\Pacchetti;

use Doctrine\ORM\Mapping as ORM;
use GuzzleHttp\Client;

/**
 * @ORM\Table(name="pacchetti__opzioniservizi")
 * @ORM\Entity(repositoryClass="App\Repository\Pacchetti\OpzioniserviziRepository")
 */
class Opzioniservizi
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=25)
     */
    private $opzione;

    /**
    * @ORM\ManyToOne(targetEntity="Servizi", inversedBy="opzioniservizi")
    * @ORM\JoinColumn(name="servizi_id", referencedColumnName="id", onDelete="CASCADE")
    */
    private $opzioniservizi;


    public function getId()
    {
        return $this->id;
    }
    public function __toString() {
      return $this->opzione;
    }

    /**
     * Set opzione
     *
     * @param string opzione
     *
     * @return Opzioniservizi
     */
    public function setOpzione($opzione)
    {
        $this->opzione = $opzione;

        return $this;
    }

    /**
     * Get opzione
     *
     * @return string
     */
    public function getOpzione()
    {
        return $this->opzione;
    }


    /**
    * Set Opzioniservizi
    *
    * @param Opzioniservizi $opzioniservizi
    *
    * @return Opzioniservizi
    */
    public function setOpzioniservizi($opzioniservizi)
    {
     $this->opzioniservizi = $opzioniservizi;

    return $this;
    }

    /**
    * Get Opzioniservizi
    *
    * @return mixed
    */
    public function getOpzioniservizi()
    {
    return $this->opzioniservizi;
    }

}
