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
            'anagrafica/aggiungi.html.twig',array(
              'form' => $form->createView(),
              'cliente' => $cliente
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
                 'No cinema found for id '.$id
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
                         // alert success //
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
         return $this->render('anagrafica/modaledit.html.twig', [
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
       return $this->render('anagrafica/aggiungi.html.twig');
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
