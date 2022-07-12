<?php

namespace App\Controller;

use App\Entity\Bike;
use App\Repository\BikeRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Form\BikeType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class BikeController extends AbstractController
{
    /**
     * @Route("/bike/{slug}", name="show_bike")
     */
    public function showBike(BikeRepository $bikeRepository, Request $request): Response
    {   

        $bike = $bikeRepository->findOneBy(['slug' => $request->get('slug')]);
        dump($bike);
        return $this->render('bike/bike.html.twig', [
            'bike' => $bike,
        ]);
    }

    /**
     * @Route("/bikes", name="list_bikes")
     */
    public function showAllBikes(BikeRepository $bikeRepository):Response
    {
        $bikes = $bikeRepository->findAll();
        dump($bikes);
        return $this->render('bike/bikeList.html.twig', [
            'bikes' => $bikes,
        ]);
    }

    /**
     * @Route("create/bike", name="create_bike", methods={"GET","POST"})
     */
    public function createBike(Request $request, EntityManagerInterface $entityManager): Response
    {

        $routeName = $request->attributes->get('_route');
        dump($routeName);
        $routeParameters = $request->attributes->get('_route_params');
        dump($routeParameters);

        $bike = new Bike();
        $form = $this->createForm(BikeType::class, $bike);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $bike = $form->getData();

            $entityManager->persist($bike);
            $entityManager->flush();

            return $this->redirectToRoute('app_home');
        }

        return $this->renderForm('bike/bikeCreate.html.twig', [
            'form' => $form,
        ]);
    }   

    /**
     * @Route("/bike/update/{slug}", name="update_bike")
     */
    public function updateStation(BikeRepository $bikeRepository, Request $request, EntityManagerInterface $entityManager):Response
    {
        $bike = $bikeRepository->findOneBy(['slug' => $request->get('slug')]);
        
        $form = $this->createForm(BikeType::class, $bike);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $bike = $form->getData();
  
            $entityManager->persist($bike);
            $entityManager->flush();

            return $this->redirectToRoute('list_bikes');
            //return $this->redirect($request->headers->get('referer'));
        }

        return $this->renderForm('bike/bikeCreate.html.twig', [
            'form' => $form,
        ]);
    }
}
