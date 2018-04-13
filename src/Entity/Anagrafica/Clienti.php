<?php

namespace App\Entity\Anagrafica;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="clienti")
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
     * @ORM\Column(type="string", length=25, unique=true)
     */
    private $nome;

    /**
     * @ORM\Column(type="string", length=64)
     */
    private $cognome;

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

}
