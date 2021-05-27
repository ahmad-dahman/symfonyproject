<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\User1Type;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/user")
 */
class UserController extends AbstractController
{
    /**
     * @Route("/", name="user_index", methods={"GET"})
     */
    public function index(UserRepository $userRepository): Response
    {
        $ThisUser = $this->getUser();
        $role = $ThisUser->getRoles();
        if($role[0]==='ROLE_ADMIN'){
            return $this->render('user/index.html.twig', [
                'users' => $userRepository->findAll(),
            ]);
        }else{
            return $this->redirectToRoute('homepage');
        }
        
    }

    /**
     * @Route("/{id}", name="user_show", methods={"GET"})
     */
    public function show(User $user): Response
    {
        $ThisUser = $this->getUser();
        $role = $ThisUser->getRoles();
        if($role[0]==='ROLE_ADMIN'){
            return $this->render('user/show.html.twig', [
                'user' => $user,
            ]);
        }else{
            return $this->redirectToRoute('homepage');
        }
        
    }

    /**
     * @Route("/{id}/edit", name="user_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, User $user): Response
    {
        $ThisUser = $this->getUser();
        $role = $ThisUser->getRoles();
        if($role[0]==='ROLE_ADMIN'){
            $form = $this->createForm(User1Type::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('user_index');
        }

        return $this->render('user/edit.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
        }else{
            return $this->redirectToRoute('homepage');
        }
    }

    /**
     * @Route("/{id}", name="user_delete", methods={"POST"})
     */
    public function delete(Request $request, User $user): Response
    {
        $ThisUser = $this->getUser();
        $role = $ThisUser->getRoles();
        if($role[0]==='ROLE_ADMIN'){
            if ($this->isCsrfTokenValid('delete'.$user->getId(), $request->request->get('_token'))) {
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->remove($user);
                $entityManager->flush();
            }
    
            return $this->redirectToRoute('user_index');
        }else{
            return $this->redirectToRoute('homepage');
        }
        
    }
}
