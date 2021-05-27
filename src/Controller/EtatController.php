<?php

namespace App\Controller;

use App\Entity\Etat;
use App\Form\EtatType;
use App\Repository\EtatRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/etat")
 */
class EtatController extends AbstractController
{
    /**
     * @Route("/", name="etat_index", methods={"GET"})
     */
    public function index(EtatRepository $etatRepository): Response
    {        
        $user = $this->getUser();
        $role = $user->getRoles();
        if($role[0]==='ROLE_USER'){
            return $this->render('etat/index.html.twig', [
                'etats' => $etatRepository->findAll(),
            ]);
        }else{
            return $this->redirectToRoute('homepage');
        }
        
    }

    /**
     * @Route("/new", name="etat_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $user = $this->getUser();
        $role = $user->getRoles();
        if($role[0]==='ROLE_USER'){
            $etat = new Etat();
        $form = $this->createForm(EtatType::class, $etat);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($etat);
            $entityManager->flush();

            return $this->redirectToRoute('etat_index');
        }

        return $this->render('etat/new.html.twig', [
            'etat' => $etat,
            'form' => $form->createView(),
        ]);
        }else{
            return $this->redirectToRoute('homepage');
        }
        
    }

    /**
     * @Route("/{id}", name="etat_show", methods={"GET"})
     */
    public function show(Etat $etat): Response
    {
        $user = $this->getUser();
        $role = $user->getRoles();
        if($role[0]==='ROLE_USER'){
            return $this->render('etat/show.html.twig', [
                'etat' => $etat,
            ]);
        }else{
            return $this->redirectToRoute('homepage');
        }
        
    }

    /**
     * @Route("/{id}/edit", name="etat_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Etat $etat): Response
    {
        $user = $this->getUser();
        if($user){
            $form = $this->createForm(EtatType::class, $etat);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('etat_index');
        }

        return $this->render('etat/edit.html.twig', [
            'etat' => $etat,
            'form' => $form->createView(),
        ]);
        }else{
            return $this->redirectToRoute('homepage');
        }
        
    }

    /**
     * @Route("/{id}", name="etat_delete", methods={"POST"})
     */
    public function delete(Request $request, Etat $etat): Response
    {
        $user = $this->getUser();
        if($user){
            // if the etat is connected to an automobile it will not be deleted or cause an exception
        if ($this->isCsrfTokenValid('show'.$etat->getId(), $request->request->get('_token'))){
            return $this->render('etat/show.html.twig', [
                'etat' => $etat,
            ]);
        }
        if ($this->isCsrfTokenValid('delete'.$etat->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($etat);
            $entityManager->flush();
        }

        return $this->redirectToRoute('etat_index');
        }else{
            return $this->redirectToRoute('homepage');
        }
        
    }
}
