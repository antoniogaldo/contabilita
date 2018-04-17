<?php

namespace App\Entity\Anagrafica;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="anagrafica__clienti")
 * @ORM\Entity(repositoryClass="App\Repository\Anagrafica\ClientiRepository")
 */
class Clienti
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
     * @ORM\Column(type="string", length=64)
     */
    private $cognome;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $data;

    /**
     * @ORM\Column(type="string", length=64)
     */
    private $luogo;

    /**
     * @ORM\Column(type="string", length=2)
     */
    private $sesso;

    /**
    * @ORM\OneToMany(targetEntity="Associati", mappedBy="associati", cascade={"persist"})
    */
    private $associati;

    /**
     * Set nome
     *
     * @param string nome
     *
     * @return Clienti
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
     * Set cognome
     *
     * @param string cognome
     *
     * @return Clienti
     */
    public function setCognome($cognome)
    {
        $this->cognome = $cognome;

        return $this;
    }

    /**
     * Get cognome
     *
     * @return string
     */
    public function getCognome()
    {
        return $this->cognome;
    }


    /**
    * Set Data
    *
    * @param \DateTime $data
    *
    * @return Clienti
    */
    public function setData($data)
    {
     $this->data = $data;

    return $this;
    }

    /**
    * Get Data
    *
    * @return \DateTime
    */
    public function getData()
    {
    return $this->data;
    }

    /**
    * Set Luogo
    *
    * @param mixed luogo
    *
    * @return Clienti
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
     * Get sesso
     *
     * @return string
     */
    public function getSesso()
    {
        return $this->sesso;
    }

    /**
     * Set sesso
     *
     * @param string sesso
     *
     * @return Clienti
     */
    public function setSesso($sesso)
    {
        $this->sesso = $sesso;

        return $this;
    }

    /**
    * Set Associati
    *
    * @param mixed associati
    *
    * @return Clienti
    */
    public function setAssociati($associati)
    {
     $this->associati = $associati;

    return $this;
    }

    /**
    * Get Associati
    *
    * @return mixed
    */
    public function getAssociati()
    {
    return $this->associati;
    }

}
