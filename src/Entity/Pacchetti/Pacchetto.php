<?php

namespace App\Entity\Pacchetti;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="pacchetti__pacchetto")
 * @ORM\Entity(repositoryClass="App\Repository\Pacchetti\PacchettoRepository")
 */
class Pacchetto
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
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $datainizio;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $datafine;

    /**
     * @ORM\Column(type="string", length=64)
     */
    private $luogo;

    /**
    * @ORM\OneToMany(targetEntity="Servizi", mappedBy="servizi", cascade={"persist", "remove"})
    */
    private $servizi;

    public function getId()
    {
        return $this->id;
    }

    /**
     * Set nome
     *
     * @param string nome
     *
     * @return Pacchetto
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
    * Set Datainizio
    *
    * @param \DateTime $datainizio
    *
    * @return Pacchetto
    */
    public function setDatainizio($datainizio)
    {
     $this->datainizio = $datainizio;

    return $this;
    }

    /**
    * Get Datainizio
    *
    * @return \DateTime
    */
    public function getDatainizio()
    {
    return $this->datainizio;
    }

    /**
    * Set Datafine
    *
    * @param \DateTime $datafine
    *
    * @return Pacchetto
    */
    public function setDatafine($datafine)
    {
     $this->datafine = $datafine;

    return $this;
    }

    /**
    * Get Datafine
    *
    * @return \DateTime
    */
    public function getDatafine()
    {
    return $this->datafine;
    }

    /**
    * Set Luogo
    *
    * @param mixed luogo
    *
    * @return Pacchetto
    */
    public function setLuogo($luogo)
    {
     $this->luogo = $luogo;

    return $this;
    }

    /**
    * Get Luogo
    *
    * @return mixed
    */
    public function getLuogo()
    {
    return $this->luogo;
    }


    /**
    * Set Servizi
    *
    * @param mixed servizi
    *
    * @return Pacchetto
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

}
