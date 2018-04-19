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
use Symfony\Component\HttpFoundation\Session\Flash\FlashBag;
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
    $associati= $em->getRepository(Associati::class)->findAll();
    // 1) build the form
    $clienti = new Clienti();
    $form = $this->createForm(ClientiType::class, $clienti);
    // 2) handle the submit (will only happen on POST)
    if ($request->isMethod('POST')) {
      $form->handleRequest($request);
      if ($form->isSubmitted() && $form->isValid()) {
        // 4) save the User!
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($clienti);
        $entityManager->flush();
        $request->getSession()
        ->getFlashBag()
        ->add('success', 'Cliente inserito con successo');
      }
      else {
        // alert insucces //
        $request->getSession()
        ->getFlashBag()
        ->add('notsuccess', 'Richiesta non riuscita');
      }
      return $this->redirectToRoute('anagrafica');
    }
    return $this->render(
      'anagrafica/clienti.html.twig',array(
        'form' => $form->createView(),
        'cliente' => $cliente,
        'associati' => $associati
      ));
    }

    /**
    * @Route("/anagrafica/edit/{id}", name="edit")
    */
    public function updateAction(Request $request,$id)
    {
      $entityManager = $this->getDoctrine()->getManager();
      $cliente = $entityManager->getRepository(Clienti::class)->find($id);
      $cliente->setNome($cliente->getNome());
      $cliente->setCognome($cliente->getCognome());
      $cliente->setData($cliente->getData());
      $cliente->setLuogo($cliente->getLuogo());
      if (!$cliente) {
        throw $this->createNotFoundException(
          'Cliente non trovato'.$id
        );
      }
      $form = $this->createForm(ClientiType::class, $cliente);
      if ($request->isMethod('POST')) {
        // handle the first form
        $form->handleRequest($request);
        // control form //
        if($form->isSubmitted() &&  $form->isValid()){
          $nome = $form['nome']->getData();
          $cognome = $form['cognome']->getData();
          $data = $form['data']->getData();
          $luogo = $form['luogo']->getData();
          $sn = $this->getDoctrine()->getManager();
          $cliente = $sn->getRepository(Clienti::class)->find($id);
          $cliente->setNome($nome);
          $cliente->setCognome($cognome);
          $cliente->setData($data);
          $cliente->setLuogo($luogo);
          $sn -> persist($cliente);
          $sn -> flush();
          $request->getSession()
          ->getFlashBag()
          ->add('success', 'Hai modificato un cliente');
        }
        else {
          // alert insucces //
          $request->getSession()
          ->getFlashBag()
          ->add('notsuccess', 'Email gia presente');
        }
        return $this->redirectToRoute('anagrafica');
      }
      return $this->render('anagrafica/clientiedit.html.twig', [
        'form' => $form->createView(),
        'cliente' => $cliente

      ]);
    }


    /**
    * @Route("/anagrafica/delete/{id}", name="delete")
    */
    public function deleteAction($id)
    {
      $entityManager = $this->getDoctrine()->getManager();
      $clienti = $entityManager->getRepository(Clienti::class)->find($id);

      if (!$clienti) {
        throw $this->createNotFoundException(
          'Cliente non trovato '.$id
        );
      }
      $entityManager->remove($clienti);
      $entityManager->flush();
      return $this->redirectToRoute('anagrafica');
      return $this->render('anagrafica/clienti.html.twig');
    }

    /**
    * @Route("/associati/create/{id}", name="associati")
    */
    public function associatiAction(Request $request,$id)
    {
      $associati = new Associati();
      $entityManager = $this->getDoctrine()->getManager();
      $clienti = $entityManager->getRepository(Clienti::class)->find($id);
      $form = $this->createForm(AssociatiType::class, $associati);
      if ($request->isMethod('POST')) {
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
          $associati = $associati->setAssociati($clienti);
          $entityManager = $this->getDoctrine()->getManager();
          $entityManager->persist($associati);
          $entityManager->flush();
          $request->getSession()
          ->getFlashBag()
          ->add('success', 'Hai modificato un cliente');
        }
        else {
          // alert insucces //
          $request->getSession()
          ->getFlashBag()
          ->add('notsuccess', 'Email gia presente');
        }
        return $this->redirectToRoute('anagrafica');
      }
      return $this->render(
        'anagrafica/associati.html.twig',array(
          'form' => $form->createView(),
          'clienti' => $clienti
        ));
      }

      /**
      * @Route("/associati/view/{id}", name="associatiview")
      */
      public function associativiewAction(Request $request,$id)
      {
        $entityManager = $this->getDoctrine()->getManager();
        $clienti = $entityManager->getRepository(Clienti::class)->find($id);
        return $this->render(
          'anagrafica/associatiview.html.twig',array(
            'clienti' => $clienti
          ));
      }

      /**
      * @Route("/anagrafica/associatidelete/{id}", name="associatidelete")
      */
      public function associatideleteAction($id)
      {
        $entityManager = $this->getDoctrine()->getManager();
        $clienti = $entityManager->getRepository(Associati::class)->find($id);

        if (!$clienti) {
          throw $this->createNotFoundException(
            'Cliente non trovato '.$id
          );
        }
        $entityManager->remove($clienti);
        $entityManager->flush();
        return $this->redirectToRoute('anagrafica');
        return $this->render('anagrafica/clienti.html.twig');
      }

}
