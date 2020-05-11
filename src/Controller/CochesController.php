<?php

namespace App\Controller;

use App\Entity\Coches;
use App\Form\CochesType;
use App\Repository\CochesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/coches")
 */
class CochesController extends AbstractController
{
    /**
     * @Route("/", name="coches_index", methods={"GET"})
     */
    public function index(CochesRepository $cochesRepository): Response
    {
        $dni = $this->get('session')->get('dni');
        $id = $this->get('session')->get('id');
            if ($dni == "admin") {
                return $this->render('coches/index.html.twig', [
                    'coches' => $cochesRepository->findAll()
                ]);
            }
            else{
                return $this->render('coches/index.html.twig', [
                    'coches' => $cochesRepository->findBy(
                        array('id_user' => $id)
                )]);
    }
}
    /**
     * @Route("/new", name="coches_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $coch = new Coches();
        $form = $this->createForm(CochesType::class, $coch);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($coch);
            $entityManager->flush();

            return $this->redirectToRoute('coches_index');
        }

        return $this->render('coches/new.html.twig', [
            'coch' => $coch,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="coches_show", methods={"GET"})
     */
    public function show(Coches $coch): Response
    {
        return $this->render('coches/show.html.twig', [
            'coch' => $coch,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="coches_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Coches $coch): Response
    {
        $form = $this->createForm(CochesType::class, $coch);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('coches_index');
        }

        return $this->render('coches/edit.html.twig', [
            'coch' => $coch,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="coches_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Coches $coch): Response
    {
        if ($this->isCsrfTokenValid('delete'.$coch->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($coch);
            $entityManager->flush();
        }

        return $this->redirectToRoute('coches_index');
    }
}
