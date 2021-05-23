<?php

namespace App\Controller;

use App\Entity\ModeleYear;
use App\Form\ModeleYearType;
use App\Repository\ModeleYearRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/modele/year")
 */
class ModeleYearController extends AbstractController
{
    /**
     * @Route("/", name="modele_year_index", methods={"GET"})
     */
    public function index(ModeleYearRepository $modeleYearRepository): Response
    {
        return $this->render('modele_year/index.html.twig', [
            'modele_years' => $modeleYearRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="modele_year_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $modeleYear = new ModeleYear();
        $form = $this->createForm(ModeleYearType::class, $modeleYear);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($modeleYear);
            $entityManager->flush();

            return $this->redirectToRoute('modele_year_index');
        }

        return $this->render('modele_year/new.html.twig', [
            'modele_year' => $modeleYear,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="modele_year_show", methods={"GET"})
     */
    public function show(ModeleYear $modeleYear): Response
    {
        return $this->render('modele_year/show.html.twig', [
            'modele_year' => $modeleYear,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="modele_year_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, ModeleYear $modeleYear): Response
    {
        $form = $this->createForm(ModeleYearType::class, $modeleYear);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('modele_year_index');
        }

        return $this->render('modele_year/edit.html.twig', [
            'modele_year' => $modeleYear,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="modele_year_delete", methods={"POST"})
     */
    public function delete(Request $request, ModeleYear $modeleYear): Response
    {
        if ($this->isCsrfTokenValid('delete'.$modeleYear->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($modeleYear);
            $entityManager->flush();
        }

        return $this->redirectToRoute('modele_year_index');
    }
}
