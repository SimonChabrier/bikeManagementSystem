<?php

namespace App\Controller\Crud;

use App\Entity\Station;
use App\Form\StationType;
use App\Repository\StationRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Service\MainPictureUploader;


/**
 * @Route("/station")
 */
class StationController extends AbstractController
{
    /**
     * @Route("/", name="app_station_index", methods={"GET"})
     */
    public function index(StationRepository $stationRepository): Response
    {
        return $this->render('station/index.html.twig', [
            'stations' => $stationRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="app_station_new", methods={"GET", "POST"})
     */
    public function new(Request $request, StationRepository $stationRepository, MainPictureUploader $MainPictureUploader): Response
    {
        $station = new Station();
        $form = $this->createForm(StationType::class, $station);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $mainPictureFile = $form->get('mainPicture')->getData();
            if ($mainPictureFile) {
                $mainPicture = $MainPictureUploader->uploadPictureService($mainPictureFile);
                $station->setMainPicture($mainPicture);   
            }

            $stationRepository->add($station);
            return $this->redirectToRoute('app_station_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('station/new.html.twig', [
            'station' => $station,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_station_show", methods={"GET"})
     */
    public function show(Station $station): Response
    {
        return $this->render('station/show.html.twig', [
            'station' => $station,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_station_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Station $station, StationRepository $stationRepository,  MainPictureUploader $MainPictureUploader): Response
    {
        $form = $this->createForm(StationType::class, $station, ['edit_mode' => true ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            
            $mainPictureFile = $form->get('mainPicture')->getData();
            if ($mainPictureFile) {
                $mainPicture = $MainPictureUploader->uploadPictureService($mainPictureFile);
                $station->setMainPicture($mainPicture);   
            }

            $stationRepository->add($station);
            return $this->redirectToRoute('app_station_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('station/edit.html.twig', [
            'station' => $station,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_station_delete", methods={"POST"})
     */
    public function delete(Request $request, Station $station, StationRepository $stationRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$station->getId(), $request->request->get('_token'))) {
            $stationRepository->remove($station);
        }

        return $this->redirectToRoute('app_station_index', [], Response::HTTP_SEE_OTHER);
    }
}
