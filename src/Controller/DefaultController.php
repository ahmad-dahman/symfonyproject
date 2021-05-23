<?php

namespace App\Controller;


use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class DefaultController extends AbstractController
{
    /**
     * @Route("/home", name="homepage", methods={"GET"})
     */
    public function index(): Response{
        return $this->render('home.html.twig');
    }
    

}