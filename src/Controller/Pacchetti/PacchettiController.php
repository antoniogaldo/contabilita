<?php

namespace App\Controller\Pacchetti;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Entity\Pacchetti\Pacchetto;
use App\Entity\Pacchetti\Servizi;
use App\Form\Pacchetti\PacchettoType;
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
}
