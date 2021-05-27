<?php

namespace App\Controller;

use App\Entity\Modele;
use App\Form\ModeleType;
use App\Repository\ModeleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/modele")
 */
class ModeleController extends AbstractController
{
    /**
     * @Route("/", name="modele_index", methods={"GET"})
     */
    public function index(ModeleRepository $modeleRepository): Response
    {
        $user = $this->getUser();
        $role = $user->getRoles();
        if($role[0]==='ROLE_ADMIN'){
            return $this->render('modele/index.html.twig', [
                'modeles' => $modeleRepository->findAll(),
            ]);
        }else{
            return $this->redirectToRoute('homepage');
        }
        
    }

    /**
     * @Route("/new", name="modele_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $user = $this->getUser();
        $role = $user->getRoles();
        if($role[0]==='ROLE_ADMIN'){
            $modele = new Modele();
        $form = $this->createForm(ModeleType::class, $modele);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($modele);
            $entityManager->flush();

            return $this->redirectToRoute('modele_index');
        }

        return $this->render('modele/new.html.twig', [
            'modele' => $modele,
            'form' => $form->createView(),
        ]);
        }else{
            return $this->redirectToRoute('homepage');
        }
        
    }

    /**
     * @Route("/{id}", name="modele_show", methods={"GET"})
     */
    public function show(Modele $modele): Response
    {
        $user = $this->getUser();
        $role = $user->getRoles();
        if($role[0]==='ROLE_ADMIN'){
            return $this->render('modele/show.html.twig', [
                'modele' => $modele,
            ]);
        }else{
            return $this->redirectToRoute('homepage');
        }
        
    }

    /**
     * @Route("/{id}/edit", name="modele_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Modele $modele): Response
    {
        $user = $this->getUser();
        $role = $user->getRoles();
        if($role[0]==='ROLE_ADMIN'){
            $form = $this->createForm(ModeleType::class, $modele);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('modele_index');
        }

        return $this->render('modele/edit.html.twig', [
            'modele' => $modele,
            'form' => $form->createView(),
        ]);
        }else{
            return $this->redirectToRoute('homepage');
        }
        
    }

    /**
     * @Route("/{id}", name="modele_delete", methods={"POST"})
     */
    public function delete(Request $request, Modele $modele): Response
    {
        $user = $this->getUser();
        $role = $user->getRoles();
        if($role[0]==='ROLE_ADMIN'){
            // if the modele is connected to a year it will not be deleted or cause an exception
        if ($this->isCsrfTokenValid('show'.$modele->getId(), $request->request->get('_token'))){
            return $this->render('modele/show.html.twig', [
                'modele' => $modele,
            ]);
        }
        if ($this->isCsrfTokenValid('delete'.$modele->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($modele);
            $entityManager->flush();
        }

        return $this->redirectToRoute('modele_index');
        }else{
            return $this->redirectToRoute('homepage');
        }
        
    }
}
