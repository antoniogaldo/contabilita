<?php

namespace App\Controller\Anagrafica;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Form\Anagrafica\ClientiType;
use App\Form\Anagrafica\AssociatiType;
use App\Entity\Anagrafica\Clienti;
use App\Entity\Anagrafica\Associati;
use GuzzleHttp\Client;

class AnagraficaController extends Controller
{
    /**
     * @Route("/anagrafica", name="anagrafica")
     */
    public function anagraficaAction(Request $request)
    {
        $em= $this->getDoctrine()->getManager();
        $cliente= $em->getRepository(Clienti::class)->findAll();
        // 1) build the form
        $clienti = new Clienti();
        $form = $this->createForm(ClientiType::class, $clienti);
        // 2) handle the submit (will only happen on POST)
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            // 4) save the User!
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($clienti);
            $entityManager->flush();
            $nome = $form->get('nome')->getData();
            $cognome = $form->get('cognome')->getData();
            $luogo = $form->get('luogo')->getData();
            $data = $form->get('data')->getData();
            $sesso = $form->get('sesso')->getData();
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
            echo $codicefiscale;
        }

        return $this->render(
            'anagrafica/aggiungi.html.twig',array(
              'form' => $form->createView(),
              'cliente' => $cliente
            ));
    }

    /**
     * @Route("/associati", name="associati")
     */
    public function associatiAction(Request $request)
    {
        // 1) build the form
        $associati = new Associati();
        $form = $this->createForm(AssociatiType::class, $associati);
        // 2) handle the submit (will only happen on POST)
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            // 4) save the User!
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($associati);
            $entityManager->flush();
            // ... do any other work - like sending them an email, etc
            // maybe set a "flash" success message for the user
            return $this->redirectToRoute('associati');
        }

        return $this->render(
            'anagrafica/associati.html.twig',array(
              'form' => $form->createView(),
            ));
    }
}
