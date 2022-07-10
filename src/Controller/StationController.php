<?php

namespace App\Controller;

use App\Entity\Station;
use App\Repository\StationRepository;
use App\Form\StationType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class StationController extends AbstractController
{
    /**
     * @Route("/list/station", name="list_station")
     */
    public function ListAllStation(StationRepository $stationRepository):Response
    {
        $stationListOrder = $stationRepository->findAllOrderedByTourOrder();
        $stationListOrderByName = $stationRepository->findAllOrderedByName();
        $stationListOrderByCity = $stationRepository->findAllOrderedByCity();
        //dd($stationListOrder);
        return $this->render('front/home.html.twig', [
            'stationsOrdered' => $stationListOrder,
            'stationsByName' => $stationListOrderByName,
            'stationsByCity' => $stationListOrderByCity
        ]);
    }

    /**
     * @Route("/create/station", name="create_station")
     */
    public function createStation(Request $request, EntityManagerInterface $entityManager): Response
    {
        $station = new Station();
        $form = $this->createForm(StationType::class, $station);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $station = $form->getData();

            $entityManager->persist($station);
            $entityManager->flush();

            return $this->redirectToRoute('app_home');
        }

        return $this->renderForm('station/stationCreate.html.twig', [
            'form' => $form,
        ]);
        
    }

    
}
