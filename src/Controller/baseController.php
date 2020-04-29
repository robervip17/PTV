<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\HttpFoundation\Session\Session;
use App\Entity\{User, Sesion};
use App\Form\{EnvioRegistroType, EnvioInicioSesionType};
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\DBAL\Connection;
use App\Repository\UserRepository;


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
     * @Route("/indexAdmin", name="indexAdmin")
     */
    public function inicioAdmin(SessionInterface $session, Request $request, UserRepository $userRepository){
        $login = $this->get('session')->get('nombre');
        if ($login == "") {
            return $this->redirectToRoute('login');
        }
        else {
            return $this->render('dashboard/indexPrinc.html.twig', [
                'users' => $userRepository->findAll()
            ]);
        }
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
        $login = $this->get('session')->get('nombre');
        if ($login == "") {
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
        else {
            return $this->redirectToRoute('cuenta');
        }
    }

    /**
     * @Route("/inicioSesion", name="login")
     */
    public function login(Request $request, SessionInterface $session){
        $login = $this->get('session')->get('nombre');
        if ($login == "") {
        $contactoTo=new User();
        $form=$this->CreateForm(EnvioInicioSesionType::Class, $contactoTo);
        $form->handleRequest($request);
        $repository = $this->getDoctrine()->getRepository(User::class);
        $malOBien = false;
        if($form->isSubmitted() && $form->isValid()){
            $usuario = $form->getData();
            $dni = $usuario->getDNI();
            $password = $usuario->getPassword();
            
            
            $buscarUsuario = $repository->findBy(
                array('DNI' => $dni, 'password' => $password)
            );

            if (!$buscarUsuario) {
                echo 'Este usuario no esta registrado o los datos introducidos no son correctos.';
                $malOBien = true;
            }
            else {
                echo 'Si que estaaaaa!';
                $em = $this->getDoctrine()->getManager();

                $RAW_QUERY = "SELECT * FROM User where User.dni = '".$dni."';";
        
                $statement = $em->getConnection()->prepare($RAW_QUERY);
                $statement->execute();

                $result = $statement->fetchAll();
                foreach($result as $index => $value){
                    $nombre = $value['nombre_completo'];
                }

                $session = $request->getSession();
                $session->start();
                $session->set('nombre', $nombre);
                return $this->redirectToRoute('cuenta');
            }
        }
         return $this->render('inicioSesion.html.twig', [
             'form' => $form->CreateView(),
             'malobien' => $malOBien
        ]);
    }
    else {
        return $this->redirectToRoute('cuenta');
    }

}

    /**
     * @Route("/pagCuenta", name="cuenta")
     */
    public function cuenta(Request $request, SessionInterface $session)
    {
        $login = $this->get('session')->get('nombre');
        return $this->render('sesionIniciada.html.twig', [
            'login' => $login
        ]);
    }

    /**
     * @Route("/logout", name="logout")
     */
    public function logout(SessionInterface $session)
    {
        $session->remove('nombre');
        return $this->redirectToRoute('login');
    }
}