<?php

namespace App\Entity\Pacchetti;

use Doctrine\ORM\Mapping as ORM;
use GuzzleHttp\Client;

/**
 * @ORM\Table(name="pacchetti__tipologiaservizi")
 * @ORM\Entity(repositoryClass="App\Repository\Pacchetti\TipologiaserviziRepository")
 */

class Tipologiaservizi
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
    private $nome;

    /**
    * @ORM\ManyToOne(targetEntity="Servizi")
    * @ORM\JoinColumn(name="servizi_id", referencedColumnName="id",onDelete="CASCADE")
    */
    private $servizi;

    /**
    * @ORM\ManyToOne(targetEntity="Opzioniservizi")
    * @ORM\JoinColumn(name="opzioniservizi_id", referencedColumnName="id", onDelete="CASCADE")
    */
    private $opzioniservizi;

    public function getId()
    {
        return $this->id;
    }

    /**
    * Set Servizi
    *
    * @param Servizi $servizi
    *
    * @return Servizi
    */
    public function setServizi($servizi)
    {
     $this->servizi = $servizi;

    return $this;
    }

    /**
    * Get Servizi
    *
    * @return mixed
    */
    public function getServizi()
    {
    return $this->servizi;
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
