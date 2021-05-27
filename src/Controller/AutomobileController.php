<?php

namespace App\Controller;

use App\Entity\Automobile;
use App\Entity\ModeleYear;

use App\Form\AutomobileType;

use App\Entity\SearchByMarque;
use App\Form\SearchByMarqueType;
use App\Entity\AutomobileHistory;
use App\Entity\SearchBymatricule;
use Doctrine\ORM\Query\Expr\Join;
use App\Form\SearchBymatriculeType;
use App\Repository\AutomobileRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Repository\SearchBymatriculeRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/automobile")
 * 
 * Require ROLE_USER for *every* controller method in this class.
 * 
 * 
 */
class AutomobileController extends AbstractController
{
    /**
     * @Route("/", name="automobile_index", methods={"GET","POST"})
     */
    public function index(AutomobileRepository $automobileRepository,  Request $request): Response
    {
        $user = $this->getUser();
        $role = $user->getRoles();
        if($role[0]==='ROLE_USER'){
            $automobiles=[];
            // rechercher automibile par matricule
        $SearchByMatricule = new SearchBymatricule();
        $formMatricule = $this->createForm(SearchBymatriculeType::class, $SearchByMatricule);
        $formMatricule->handleRequest($request);

        // rechercher automibile par marque
        $SearchByMarque = new SearchByMarque();
        $formMarque = $this->createForm(SearchByMarqueType::class, $SearchByMarque);
        $formMarque->handleRequest($request);

        
        if (($formMatricule->isSubmitted() && $formMatricule->isValid())||($formMarque->isSubmitted() && $formMarque->isValid())) {
            if ($formMatricule->isSubmitted() && $formMatricule->isValid()){
                $n_immatriculation = $SearchByMatricule->getNImmatriculation();
                if ($n_immatriculation!="") {
                    //si on a fourni un matricule d'automobile on affiche tous les automobiles ayant ce matricule
                    $automobiles = $this->getDoctrine()->getRepository(Automobile::class)->findBy(['n_immatriculation'=>$n_immatriculation]);
                } else {
                    //si si aucun nom n'est fourni on affiche tous les automobiles
                    $automobiles = $this->getDoctrine()->getRepository(Automobile::class)->findAll();
                }
            }
            if ($formMarque->isSubmitted() && $formMarque->isValid()) {
                $marque = $formMarque->get('Marque')->getData()->getId();
                if ($marque!="") {
                    //si on a fourni un matricule d'automobile on affiche tous les automobiles ayant ce matricule
                    $automobiles = $this->getDoctrine()->getRepository(Automobile::class)->findBy(['marque'=>$marque]);
                } else {
                    //si si aucun nom n'est fourni on affiche tous les automobiles
                    $automobiles = $this->getDoctrine()->getRepository(Automobile::class)->findAll();
                }
            }            
            return $this->render('automobile/index.html.twig', [ 'formMatricule' =>$formMatricule->createView(),'formMarque' =>$formMarque->createView(),
             'automobiles'=>$automobiles]);
            
        }else{
            $automobiles=$automobileRepository->findAll();
            return $this->render('automobile/index.html.twig', ['formMatricule' =>$formMatricule->createView(),'formMarque' =>$formMarque->createView(),
            'automobiles' => $automobiles
        ]);

        }
    }else{
        return $this->redirectToRoute('homepage');
    }     
    }

    /**
     * @Route("/new", name="automobile_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $user = $this->getUser();
        $role = $user->getRoles();
        if($role[0]==='ROLE_USER'){
            $automobile = new Automobile();
        $AutomobileHistory = new AutomobileHistory();
        $form = $this->createForm(AutomobileType::class, $automobile);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            //to upload the image
            $imageFile = $form->get('image')->getData();
            $fileName = md5(uniqid()).'.'.$imageFile->getExtension();
            $imageFile->move( $this->getParameter('image_directory'), $fileName);
            $automobile->setImage($fileName);
            $automobile = $form->getData();
            //
            //remplir table automobilehistory moment de creer l'automobile
            $matricule = $form->get('n_immatriculation')->getData();
            $etat = $form->get('etat')->getData();
            $kilometrage = $form->get('Kilometrage')->getData();
            $AutomobileHistory->setNImmatriculation($matricule);
            $AutomobileHistory->setKilometrage($kilometrage);
            $AutomobileHistory->setEtat($etat);
            $AutomobileHistory->setDate(\date("Y-m-d h:i:sa"));
            //
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($automobile);
            $entityManager->persist($AutomobileHistory);
            $entityManager->flush();

            return $this->redirectToRoute('automobile_index');
        }

        return $this->render('automobile/new.html.twig', [
            'automobile' => $automobile,
            'form' => $form->createView(),
        ]);
        }else{
            return $this->redirectToRoute('homepage');
        }
        
    }

    /**
     * @Route("/{id}", name="automobile_show", methods={"GET"})
     */
    public function show(Automobile $automobile): Response
    {
        $user = $this->getUser();
        $role = $user->getRoles();
        if($role[0]==='ROLE_USER'){
            return $this->render('automobile/show.html.twig', [
                'automobile' => $automobile,
            ]);
        }else{
            return $this->redirectToRoute('homepage');
        }
        
    }

    /**
     * @Route("/{id}/edit", name="automobile_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Automobile $automobile): Response
    {
        $user = $this->getUser();
        $role = $user->getRoles();
        if($role[0]==='ROLE_USER'){
            $AutomobileHistory = new AutomobileHistory();
        $form = $this->createForm(AutomobileType::class, $automobile);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            //to upload the image
            $imageFile = $form->get('image')->getData();
            $fileName = md5(uniqid()).'.'.$imageFile->getExtension();
            $imageFile->move( $this->getParameter('image_directory'), $fileName);
            $automobile->setImage($fileName);
            $automobile = $form->getData();

            //remplir table automobilehistory moment de editer l'automobile
            $matricule = $form->get('n_immatriculation')->getData();
            $etat = $form->get('etat')->getData();
            $kilometrage = $form->get('Kilometrage')->getData();

            $AutomobileHistory->setNImmatriculation($matricule);
            $AutomobileHistory->setKilometrage($kilometrage);
            $AutomobileHistory->setEtat($etat);
            $AutomobileHistory->setDate(\date("Y-m-d h:i:sa"));
            //
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($AutomobileHistory);
            $entityManager->flush();

            return $this->redirectToRoute('automobile_index');
        }

        return $this->render('automobile/edit.html.twig', [
            'automobile' => $automobile,
            'form' => $form->createView(),
        ]);
        }else{
            return $this->redirectToRoute('homepage');
        }
        
    }

    /**
     * @Route("/{id}", name="automobile_delete", methods={"POST"})
     */
    public function delete(Request $request, Automobile $automobile): Response
    {
        $user = $this->getUser();
        $role = $user->getRoles();
        if($role[0]==='ROLE_USER'){
            if ($this->isCsrfTokenValid('delete'.$automobile->getId(), $request->request->get('_token'))) {
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->remove($automobile);
                $entityManager->flush();
            }
    
            return $this->redirectToRoute('automobile_index');
        }else{
            return $this->redirectToRoute('homepage');
        }
        
    }

    /**
     * Returns a JSON string with the modeles of the marque with the providen id.
     * 
     * @param Request $request
     * @return JsonResponse
     */
    public function listModelesOfMarqueAction(Request $request)
    {
        // Get Entity manager and repository
        $em = $this->getDoctrine()->getManager();
        $modelesRepository = $em->getRepository("App:Modele");
        
        // Search the modeles that belongs to the marque with the given id as GET parameter "marqueid"
        $modeles = $modelesRepository->createQueryBuilder("q")
            ->where("q.marque = :marqueid")
            ->setParameter("marqueid", $request->query->get("marqueid"))
            ->getQuery()
            ->getResult();
        
        // Serialize into an array the data that we need, in this case only name and id
        // Note: you can use a serializer as well, for explanation purposes, we'll do it manually
        $responseArray = array();
        foreach($modeles as $modele){
            $responseArray[] = array(
                "id" => $modele->getId(),
                "modele" => $modele->getNomModele()
            );
        }
        
        // Return array with structure of the modeles of the providen marque id
        return new JsonResponse($responseArray);

        // e.g
        // [{"id":"3","modele":"X7"},{"id":"4","modele":"X6"}]
    }

    /**
     * Returns a JSON string with the years of the modele with the providen id.
     * 
     * @param Request $request
     * @return JsonResponse
     */
    public function listYearsOfModeleAction(Request $request)
    {
        // Get Entity manager and repository
        $em = $this->getDoctrine()->getManager();
        $yearRepository = $em->getRepository("App:Year");
        
        // Search the years that belongs to the modele with the given id as GET parameter "modeleid"
        $years = $yearRepository->createQueryBuilder("p")
            -> innerjoin("App:ModeleYear","c" , Join::WITH, "c.year_id = p.id")
            ->where("c.modele_id = :modeleid")
            ->setParameter("modeleid", $request->query->get("modeleid"))
            ->getQuery()
            ->getResult();
        
        // Serialize into an array the data that we need, in this case only year and id
        // Note: you can use a serializer as well, for explanation purposes, we'll do it manually
        $responseArray = array();
        foreach($years as $year){
            $responseArray[] = array(
                "id" => $year->getId(),
                "year" => $year->getProductionYear()
                
            );
        }
        
        // Return array with structure of the years of the providen modele id
        return new JsonResponse($responseArray);

        // e.g
        // [{"id":"3","year":"2019"},{"id":"4","year":"2020"}]
    }

    

}
