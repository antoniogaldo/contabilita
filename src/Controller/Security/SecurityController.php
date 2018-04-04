<?php

namespace App\Controller\Security;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends Controller
{
  /**
   * @Route("/", name="entry")
   */
   public function entryAction(Request $request)
   {
       return $this->redirect($this->generateUrl('login'));
   }

   /**
    * @Route("/login", name="login")
    */
   public function login(Request $request, AuthenticationUtils $authenticationUtils)
   {
    // get the login error if there is one
    $error = $authenticationUtils->getLastAuthenticationError();

    // last username entered by the user
    $lastUsername = $authenticationUtils->getLastUsername();

    return $this->render('security/index.html.twig', array(
        'last_username' => $lastUsername,
        'error'         => $error,
    ));
  }
}
