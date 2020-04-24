<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\HttpFoundation\Session\Session;
use App\Entity\User;
use App\Form\EnvioRegistroType;

class baseController extends AbstractController
{
    /**
     * @Route("/inicio", name="inicio")
     */
    public function inicio(SessionInterface $session, Request $request){
        $login = $request->request->get('user');
        return $this->render('inicio.html.twig', [
            'login' => $login
       ]);
    }

    /**
     * @Route("/servicios")
     */
    public function servicios(SessionInterface $session, Request $request){
        $login = $request->request->get('user');
        return $this->render('servicios.html.twig', [
            'login' => $login]);
    }

    /**
     * @Route("/registro")
     */
    public function registro(Request $request, SessionInterface $session){
        $contactoTo=new User();
        $form=$this->CreateForm(EnvioRegistroType::Class, $contactoTo);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $entityManager=$this->getDoctrine()->getManager();
            $entityManager->persist($contactoTo);
            $entityManager->flush();}
        return $this->render('registro.html.twig', [
            'form' => $form->CreateView()
        ]);
    }


    /**
     * @Route("/inicioSesion", name="login")
     */
    public function login(SessionInterface $session){
        $login = $session->get('username');
        var_dump($login);
        if ($login == "") {
         return $this->render('inicioSesion.html.twig', [
             'login' => $login
        ]);
     }
     else {
         return $this->redirectToRoute('cuenta');
     }
    }

    /**
     * @Route("/loggedin", name="logging")
     */
    public function logging(Request $request, SessionInterface $session)
    {
        $session = $request->getSession();
        $session->start();
        $session->set('username', $request->request->get('user'));
        return $this->redirectToRoute('cuenta');
    }

    /**
     * @Route("/pagCuenta", name="cuenta")
     */
    public function cuenta(Request $request, SessionInterface $session)
    {
        $login = $request->request->get('user');
        return $this->render('sesionIniciada.html.twig', [
            'login' => $login
        ]);
    }

    /**
     * @Route("/logout", name="logout")
     */
    public function logout(SessionInterface $session)
    {
        $session->remove('username');
        return $this->redirectToRoute('login');
    }
}