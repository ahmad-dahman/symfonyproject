<?php

namespace App\Controller;

use App\Entity\AutomobileHistory;
use App\Entity\SearchBymatricule;
use App\Form\SearchBymatriculeType;
use App\Repository\HistoryRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HistoryController extends AbstractController
{
    /**
     * @Route("/history", name="history")
     */
    public function index(HistoryRepository $HistoryRepository, request $request): Response
    {
        $SearchByMatricule = new SearchBymatricule();
        $form = $this->createForm(SearchBymatriculeType::class, $SearchByMatricule);
        $form->handleRequest($request);
        $historys=[];
        if ($form->isSubmitted() && $form->isValid()) {
            $n_immatriculation = $SearchByMatricule->getNImmatriculation();
            if ($n_immatriculation!="") {
                //si on a fourni un matricule d'automobile on affiche tous les automobiles ayant ce matricule
                $historys = $this->getDoctrine()->getRepository(AutomobileHistory::class)->findBy(['n_immatriculation'=>$n_immatriculation]);
            } else {
                //si si aucun nom n'est fourni on affiche tous les automobiles
                $historys = $this->getDoctrine()->getRepository(AutomobileHistory::class)->findAll();
            }
            return $this->render('history/index.html.twig', [ 'formSearch' =>$form->createView(),
             'historys'=>$historys]);
            
        }else{
            $historys=$HistoryRepository->findAll();
            return $this->render('history/index.html.twig', ['formSearch' =>$form->createView(),
            'historys' => $historys
        ]);

        }
    }
}
