<?php

namespace App\Controller;

use App\Entity\Marque;
use App\Form\MarqueType;
use App\Repository\MarqueRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/marque")
 */
class MarqueController extends AbstractController
{
    /**
     * @Route("/", name="marque_index", methods={"GET"})
     */
    public function index(MarqueRepository $marqueRepository): Response
    {
        $user = $this->getUser();
        $role = $user->getRoles();
        if($role[0]==='ROLE_ADMIN'){
            return $this->render('marque/index.html.twig', [
                'marques' => $marqueRepository->findAll(),
            ]);
        }else{
            return $this->redirectToRoute('homepage');
        }
        
    }

    /**
     * @Route("/new", name="marque_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $user = $this->getUser();
        $role = $user->getRoles();
        if($role[0]==='ROLE_ADMIN'){
            $marque = new Marque();
        $form = $this->createForm(MarqueType::class, $marque);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            //upload an image
            $imageFile = $form->get('image')->getData();
            $fileName = md5(uniqid()).'.'.$imageFile->getExtension();
            $imageFile->move( $this->getParameter('image_directory'), $fileName);
            $marque->setImage($fileName);
            $marque = $form->getData();


            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($marque);
            $entityManager->flush();

            return $this->redirectToRoute('marque_index');
        }

        return $this->render('marque/new.html.twig', [
            'marque' => $marque,
            'form' => $form->createView(),
        ]);
        }else{
            return $this->redirectToRoute('homepage');
        }
        
    }

    /**
     * @Route("/{id}", name="marque_show", methods={"GET"})
     */
    public function show(Marque $marque): Response
    {
        $user = $this->getUser();
        $role = $user->getRoles();
        if($role[0]==='ROLE_ADMIN'){
            return $this->render('marque/show.html.twig', [
                'marque' => $marque,
            ]);
        }else{
            return $this->redirectToRoute('homepage');
        }
        
    }

    /**
     * @Route("/{id}/edit", name="marque_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Marque $marque): Response
    {
        $user = $this->getUser();
        $role = $user->getRoles();
        if($role[0]==='ROLE_ADMIN'){
            $form = $this->createForm(MarqueType::class, $marque);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            //upload an image
            $imageFile = $form->get('image')->getData();
            $fileName = md5(uniqid()).'.'.$imageFile->getExtension();
            $imageFile->move( $this->getParameter('image_directory'), $fileName);
            $marque->setImage($fileName);
            $marque = $form->getData();
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('marque_index');
        }

        return $this->render('marque/edit.html.twig', [
            'marque' => $marque,
            'form' => $form->createView(),
        ]);
        }else{
            return $this->redirectToRoute('homepage');
        }
        
    }

    /**
     * @Route("/{id}", name="marque_delete", methods={"POST"})
     */
    public function delete(Request $request, Marque $marque): Response
    {
        $user = $this->getUser();
        $role = $user->getRoles();
        if($role[0]==='ROLE_ADMIN'){
            // if the marque is connected to an automobile or modele it will not be deleted or cause an exception
        if ($this->isCsrfTokenValid('show'.$marque->getId(), $request->request->get('_token'))){
            return $this->render('marque/show.html.twig', [
                'marque' => $marque,
            ]);
        }
        if ($this->isCsrfTokenValid('delete'.$marque->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($marque);
            $entityManager->flush();
        }

        return $this->redirectToRoute('marque_index');
        }else{
            return $this->redirectToRoute('homepage');
        }
        
    }
}
