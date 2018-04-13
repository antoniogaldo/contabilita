<?php

namespace App\Controller\Anagrafica;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Form\Anagrafica\ClientiType;
use App\Entity\Anagrafica\Clienti;

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
            // ... do any other work - like sending them an email, etc
            // maybe set a "flash" success message for the user
            return $this->redirectToRoute('anagrafica');
        }

        return $this->render(
            'anagrafica/aggiungi.html.twig',array(
              'form' => $form->createView(),
              'cliente' => $cliente
            ));
    }
}