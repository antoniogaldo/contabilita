<?php

namespace App\Controller\Pacchetti;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Entity\Pacchetti\Pacchetto;
use App\Entity\Pacchetti\Servizi;
use App\Entity\Pacchetti\Opzioniservizi;
use App\Entity\Pacchetti\Tipologiaservizi;
use App\Form\Pacchetti\PacchettoType;
use App\Form\Pacchetti\ServiziType;
use App\Form\Pacchetti\OpzioniserviziType;
use App\Form\Pacchetti\TipologiaserviziType;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBag;

class PacchettiController extends Controller
{
  /**
  * @Route("/pacchetto", name="pacchetto")
  */
  public function pacchettoAction(Request $request)
  {
    $em= $this->getDoctrine()->getManager();
    $pacchetti= $em->getRepository(Pacchetto::class)->findAll();
    $servizi= $em->getRepository(Servizi::class)->findAll();
    // 1) build the form
    $pacchetto = new Pacchetto();
    $form = $this->createForm(PacchettoType::class, $pacchetto);
    // 2) handle the submit (will only happen on POST)
    if ($request->isMethod('POST')) {
      $form->handleRequest($request);
      if ($form->isSubmitted() && $form->isValid()) {
        // 4) save the User!
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($pacchetto);
        $entityManager->flush();
        $request->getSession()
        ->getFlashBag()
        ->add('success', 'Pacchetto inserito con successo');
      }
      else {
        // alert insucces //
        $request->getSession()
        ->getFlashBag()
        ->add('notsuccess', 'Richiesta non riuscita');
      }
      return $this->redirectToRoute('pacchetto');
    }
    return $this->render(
      'pacchetti/pacchetto.html.twig',array(
        'form' => $form->createView(),
        'pacchetti' => $pacchetti,
        'servizi' => $servizi
      ));
    }

    /**
    * @Route("/pacchetto/edit/{id}", name="pacchettoedit")
    */
    public function pacchettoupdateAction(Request $request,$id)
    {
      $entityManager = $this->getDoctrine()->getManager();
      $pacchetto = $entityManager->getRepository(Pacchetto::class)->find($id);
      $pacchetto->setNome($pacchetto->getNome());
      $pacchetto->setDatainizio($pacchetto->getDatainizio());
      $pacchetto->setDatafine($pacchetto->getDatafine());
      $pacchetto->setLuogo($pacchetto->getLuogo());
      if (!$pacchetto) {
        throw $this->createNotFoundException(
          'Pacchetto non trovato'.$id
        );
      }
      $form = $this->createForm(PacchettoType::class, $pacchetto);
      if ($request->isMethod('POST')) {
        // handle the first form
        $form->handleRequest($request);
        // control form //
        if($form->isSubmitted() &&  $form->isValid()){
          $nome = $form['nome']->getData();
          $datainizio = $form['datainizio']->getData();
          $datafine = $form['datafine']->getData();
          $luogo = $form['luogo']->getData();
          $sn = $this->getDoctrine()->getManager();
          $pacchetto = $sn->getRepository(Pacchetto::class)->find($id);
          $pacchetto->setNome($nome);
          $pacchetto->setDatainizio($datainizio);
          $pacchetto->setDatafine($datafine);
          $pacchetto->setLuogo($luogo);
          $sn -> persist($pacchetto);
          $sn -> flush();
          $request->getSession()
          ->getFlashBag()
          ->add('success', 'Hai modificato un pacchetto');
        }
        else {
          // alert insucces //
          $request->getSession()
          ->getFlashBag()
          ->add('notsuccess', 'Email gia presente');
        }
        return $this->redirectToRoute('pacchetto');
      }
      return $this->render('pacchetti/pacchettoedit.html.twig', [
        'form' => $form->createView(),
        'pacchetto' => $pacchetto

      ]);
    }


    /**
    * @Route("/pacchetto/delete/{id}", name="pacchettodelete")
    */
    public function pacchettodeleteAction($id)
    {
      $entityManager = $this->getDoctrine()->getManager();
      $pacchetto = $entityManager->getRepository(Pacchetto::class)->find($id);

      if (!$pacchetto) {
        throw $this->createNotFoundException(
          'Pacchetto non trovato '.$id
        );
      }
      $entityManager->remove($pacchetto);
      $entityManager->flush();
      return $this->redirectToRoute('pacchetto');
      return $this->render('pacchetti/pacchetto.html.twig');
    }

    /**
    * @Route("/servizi/create/{id}", name="servizicreate")
    */
    public function servizicreateAction(Request $request,$id)
    {
      $tipologiaservizi = new Tipologiaservizi();
      $entityManager = $this->getDoctrine()->getManager();
      $pacchetto = $entityManager->getRepository(Pacchetto::class)->find($id);
      $form = $this->createForm(TipologiaserviziType::class, $tipologiaservizi);
      if ($request->isMethod('POST')) {
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
          $entityManager = $this->getDoctrine()->getManager();
          $entityManager->persist($tipologiaservizi);
          $entityManager->flush();
          $request->getSession()
          ->getFlashBag()
          ->add('success', 'Hai creato un servizio');
        }
        else {
          // alert insucces //
          $request->getSession()
          ->getFlashBag()
          ->add('notsuccess', 'Errore associato');
        }
      }
      return $this->render(
        'pacchetti/servizi.html.twig',array(
          'form' => $form->createView(),
          'pacchetto' => $pacchetto
        ));
      }

      /**
      * @Route("/servizi/view/{id}", name="serviziview")
      */
      public function serviziviewAction(Request $request,$id)
      {
        $entityManager = $this->getDoctrine()->getManager();
        $pacchetto = $entityManager->getRepository(Pacchetto::class)->find($id);
        return $this->render(
          'pacchetti/serviziview.html.twig',array(
            'pacchetto' => $pacchetto
          ));
      }

      /**
      * @Route("/opzioniservizi/create", name="opzioniservizi")
      */
      public function opzioniserviziAction(Request $request)
      {
        $entityManager = $this->getDoctrine()->getManager();
        $serviziviews = $entityManager->getRepository(Servizi::class)->findAll();
        $servizi = new servizi();
        $opzioniservizi = new opzioniservizi();
        $form = $this->createForm(ServiziType::class, $servizi);
        $form1 = $this->createForm(OpzioniserviziType::class, $opzioniservizi);
        if ($request->isMethod('POST')) {
          $form->handleRequest($request);
          if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($servizi);
            $entityManager->flush();
            $request->getSession()
            ->getFlashBag()
            ->add('success', 'Servizio inserito con successo');
          }
            else {
              // alert insucces //
              $request->getSession()
              ->getFlashBag()
              ->add('notsuccess', 'Richiesta non riuscita');
            }
            unset($servizi);
            unset($form);
            $servizi = new servizi();
            $form = $this->createForm(ServiziType::class, $servizi);
        }
        if ($request->isMethod('POST')) {
          $form1->handleRequest($request);
          if ($form1->isSubmitted() && $form1->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($opzioniservizi);
            $entityManager->flush();
            $request->getSession()
            ->getFlashBag()
            ->add('success', 'Opzione inserita con successo');
            }
              else {
                // alert insucces //
                $request->getSession()
                ->getFlashBag()
                ->add('notsuccess', 'Richiesta non riuscita');
              }
            unset($opzioniservizi);
            unset($form1);
            $opzioniservizi = new opzioniservizi();
            $form1 = $this->createForm(OpzioniserviziType::class, $opzioniservizi);

        }
        return $this->render(
          'pacchetti/opzioneservizi.html.twig',array(
            'form' => $form->createView(),
            'form1' => $form1->createView(),
            'serviziviews'=>$serviziviews,
          ));
        }

}
