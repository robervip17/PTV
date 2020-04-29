<?php

namespace App\Controller;

use App\Entity\Reparaciones;
use App\Form\ReparacionesType;
use App\Repository\ReparacionesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/reparaciones")
 */
class ReparacionesController extends AbstractController
{
    /**
     * @Route("/", name="reparaciones_index", methods={"GET"})
     */
    public function index(ReparacionesRepository $reparacionesRepository): Response
    {
        return $this->render('reparaciones/index.html.twig', [
            'reparaciones' => $reparacionesRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="reparaciones_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $reparacione = new Reparaciones();
        $form = $this->createForm(ReparacionesType::class, $reparacione);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($reparacione);
            $entityManager->flush();

            return $this->redirectToRoute('reparaciones_index');
        }

        return $this->render('reparaciones/new.html.twig', [
            'reparacione' => $reparacione,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="reparaciones_show", methods={"GET"})
     */
    public function show(Reparaciones $reparacione): Response
    {
        return $this->render('reparaciones/show.html.twig', [
            'reparacione' => $reparacione,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="reparaciones_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Reparaciones $reparacione): Response
    {
        $form = $this->createForm(ReparacionesType::class, $reparacione);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('reparaciones_index');
        }

        return $this->render('reparaciones/edit.html.twig', [
            'reparacione' => $reparacione,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="reparaciones_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Reparaciones $reparacione): Response
    {
        if ($this->isCsrfTokenValid('delete'.$reparacione->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($reparacione);
            $entityManager->flush();
        }

        return $this->redirectToRoute('reparaciones_index');
    }
}
