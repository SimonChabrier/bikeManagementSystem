<?php

namespace App\Controller;

use App\Entity\Station;
use App\Form\StationType;
use App\Form\StationTourType;
use App\Repository\StationRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class StationController extends AbstractController
{

    /**
     * @Route("/station/{slug}", name="show_station")
     */
    public function showStation(StationRepository $stationRepository, Request $request):Response
    {
        $station = $stationRepository->findOneBy(['slug' => $request->get('slug')]);
        
        return $this->render('front/station.html.twig', [
            'station' => $station,
        ]);
    }

    /**
     * @Route("/stations", name="list_station")
     */
    public function showAllStation(StationRepository $stationRepository):Response
    {
        $stationListOrder = $stationRepository->findAllOrderedByTourOrder();
        $stationListOrderByName = $stationRepository->findAllOrderedByName();
        $stationListOrderByCity = $stationRepository->findAllOrderedByCity();
        dump($stationListOrderByName);
        return $this->render('front/tourOrder.html.twig', [
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

    /**
     * @Route("/update/station/{slug}", name="update_station")
     */
    public function updateStation(StationRepository $stationRepository, Request $request, EntityManagerInterface $entityManager):Response
    {
        $station = $stationRepository->findOneBy(['slug' => $request->get('slug')]);
        
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
    
    /**
     * @Route("/update/station/tour/{slug}", name="order_station")
     */
    public function adminTourOrder(StationRepository $stationRepository, Request $request, EntityManagerInterface $entityManager)
    {

        $station = $stationRepository->findOneBy(['slug' => $request->get('slug')]);
        $form = $this->createForm(StationTourType::class, $station);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            
            $station = $form->getData();

            $entityManager->persist($station);
            $entityManager->flush();

            return $this->redirect($request->headers->get('referer'));
        }

        $stationListOrderByName = $stationRepository->findAllOrderedByName();

        return $this->renderForm('front/stationTourAdmin.html.twig', [
            'form' => $form,
            'stationListOrderByName' => $stationListOrderByName
        ]);

    }
}