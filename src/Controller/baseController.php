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
        $login = $this->get('session')->get('nombre');
        if ($login == "") {
        $contactoTo=new User();
        $form=$this->CreateForm(EnvioRegistroType::Class, $contactoTo);
        $form->handleRequest($request);
        var_dump($contactoTo);
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
        if($form->isSubmitted() && $form->isValid()){
            $usuario = $form->getData();
            $dni = $usuario->getDNI();
            $password = $usuario->getPassword();
            
            var_dump($password);
            $buscarUsuario = $repository->findBy(
                array('DNI' => $dni, 'password' => $password)
            );
            if (!$buscarUsuario) {
                echo 'No esta bro.';
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
                var_dump($result);
                $session = $request->getSession();
                $session->start();
                $session->set('nombre', $nombre);
                return $this->redirectToRoute('cuenta');
            }
        }
         return $this->render('inicioSesion.html.twig', [
             'form' => $form->CreateView()
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
        var_dump($login);
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