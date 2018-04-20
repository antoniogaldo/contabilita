<?php

namespace App\Entity\Anagrafica;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;
use GuzzleHttp\Client;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Table(name="anagrafica__clienti")
 * @UniqueEntity("codicefiscale")
 * @ORM\Entity(repositoryClass="App\Repository\Anagrafica\ClientiRepository")
 * @ORM\HasLifecycleCallbacks()
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
     * @ORM\Column(type="string", length=64, nullable=false, unique=true)
     */
    private $codicefiscale;

    /**
    * @ORM\OneToMany(targetEntity="Associati", mappedBy="associati", cascade={"persist", "remove"})
    */
    private $associati;

    public function getId()
    {
        return $this->id;
    }

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
     * Get sesso
     *
     * @return string
     */
    public function getSesso()
    {
        return $this->sesso;
    }

    /**
     * @ORM\PrePersist
     */
    public function setCodicefiscale($codicefiscale)
    {
      $nome = $this->getNome();
      $cognome = $this->getCognome();
      $luogo = $this->getLuogo();
      $data = $this->getData();
      $sesso = $this->getSesso();
      $data = $data->format('d/m/Y');
      $client = new Client([
          // Base URI is used with relative requests
          'base_uri' => 'http://webservices.dotnethell.it/codicefiscale.asmx/CalcolaCodiceFiscale',
          // You can set any number of default request options.
          'timeout'  => 2.0,
      ]);
      $res = $client->request('POST', 'http://webservices.dotnethell.it/codicefiscale.asmx/CalcolaCodiceFiscale', array(
        'form_params' => array(
          'Nome' => $nome,
          'Cognome' => $cognome,
          'ComuneNascita' => $luogo,
          'DataNascita' => $data,
          'Sesso' => $sesso,
      ),
        'headers' => [
            'Content-Type' => 'application/x-www-form-urlencoded',
            ]));
      $codicefiscale = $res->getBody()->getContents();
      $codicefiscale = simplexml_load_string($codicefiscale);
      $this->codicefiscale = $codicefiscale;
      return $this;
    }

    /**
     * Get codicefiscale
     *
     * @return string
     */
    public function getCodicefiscale()
    {
        return $this->codicefiscale;
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
