<?php

namespace App\Controller;

use App\Entity\Year;
use App\Form\YearType;
use App\Repository\YearRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/year")
 */
class YearController extends AbstractController
{
    /**
     * @Route("/", name="year_index", methods={"GET"})
     */
    public function index(YearRepository $yearRepository): Response
    {
        $user = $this->getUser();
        if($user){
            return $this->render('year/index.html.twig', [
                'years' => $yearRepository->findAll(),
            ]);
        }else{
            return $this->redirectToRoute('homepage');
        }
        
    }

    /**
     * @Route("/new", name="year_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $user = $this->getUser();
        if($user){
            $year = new Year();
        $form = $this->createForm(YearType::class, $year);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($year);
            $entityManager->flush();

            return $this->redirectToRoute('year_index');
        }

        return $this->render('year/new.html.twig', [
            'year' => $year,
            'form' => $form->createView(),
        ]);
        }else{
            return $this->redirectToRoute('homepage');
        }
        
    }

    /**
     * @Route("/{id}", name="year_show", methods={"GET"})
     */
    public function show(Year $year): Response
    {
        $user = $this->getUser();
        if($user){
            return $this->render('year/show.html.twig', [
                'year' => $year,
            ]);
        }else{
            return $this->redirectToRoute('homepage');
        }
        
    }

    /**
     * @Route("/{id}/edit", name="year_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Year $year): Response
    {
        $user = $this->getUser();
        if($user){
            $form = $this->createForm(YearType::class, $year);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('year_index');
        }

        return $this->render('year/edit.html.twig', [
            'year' => $year,
            'form' => $form->createView(),
        ]);
        }else{
            return $this->redirectToRoute('homepage');
        }
        
    }

    /**
     * @Route("/{id}", name="year_delete", methods={"POST"})
     */
    public function delete(Request $request, Year $year): Response
    {
        $user = $this->getUser();
        if($user){
            // if the year is connected to an automobile or modele it will not be deleted or cause an exception
        if ($this->isCsrfTokenValid('show'.$year->getId(), $request->request->get('_token'))){
            return $this->render('year/show.html.twig', [
                'year' => $year,
            ]);
        }
        if ($this->isCsrfTokenValid('delete'.$year->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($year);
            $entityManager->flush();
        }

        return $this->redirectToRoute('year_index');
    
        }else{
            return $this->redirectToRoute('homepage');
        }
    }
}
