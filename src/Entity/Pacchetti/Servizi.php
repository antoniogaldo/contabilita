<?php

namespace App\Entity\Pacchetti;

use Doctrine\ORM\Mapping as ORM;
use GuzzleHttp\Client;

/**
 * @ORM\Table(name="pacchetti__servizi")
 * @ORM\Entity(repositoryClass="App\Repository\Pacchetti\ServiziRepository")
 */
class Servizi
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
    * @ORM\ManyToOne(targetEntity="Pacchetto", inversedBy="servizi")
    * @ORM\JoinColumn(name="pacchetto_id", referencedColumnName="id", onDelete="SET NULL")
    */
    private $servizi;

    /**
    * @ORM\OneToMany(targetEntity="Opzioniservizi", mappedBy="opzioniservizi", cascade={"persist", "remove"})
    */
    private $opzioniservizi;


    public function getId()
    {
        return $this->id;
    }

    public function __toString() {
      return $this->getNome();
    }
    
    /**
     * Set nome
     *
     * @param string nome
     *
     * @return Servizi
     */
    public function setNome($nome)
    {
        $this->nome = $nome;

        return $this;
    }

    /**
     * Get nome
     *
     * @return string
     */
    public function getNome()
    {
        return $this->nome;
    }


    /**
    * Set Servizi
    *
    * @param Servizi $servizi
    *
    * @return Servizi
    */
    public function setServizi(Pacchetto $servizi = null)
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
    * @param mixed opzioniservizi
    *
    * @return Servizi
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
