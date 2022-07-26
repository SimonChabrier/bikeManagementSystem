<?php

namespace App\Controller\Admin;

use DateTime;
use App\Entity\Bike;
use App\Repository\BalanceRepository;
use App\Repository\BikeRepository;
use App\Repository\InventoryRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


/**
 * @Route("/admin")
 */
class AdminController extends AbstractController
{
    /**
     * @Route("/", name="app_admin_index")
     */
    public function index(BikeRepository $bikeRepository, 
    InventoryRepository $inventoryRepository,
    BalanceRepository $balanceRepository): Response
    {

        
        //TODO - afficher l'ensemble des vélos mis à jour aujourd'hui
        $bikes = $bikeRepository->findAllBikesUpdatedToday();

        //TODO - afficher l'ensemble des vélos déclarés indiponibles
        $unavalableBikes = $bikeRepository->findAllbikesUnavalable();

        //TODO - afficher l'ensemble des inventaires du jour
        $todayInventories = $inventoryRepository->findAllInventoriesUpdatedToday();

        //TODO - afficher l'ensemble des équilibrages du jour
        $todayBalances = $balanceRepository->findAllBalancesUpdatedToday();
        dump($todayBalances);
        //TODO - afficher l'ensemble des réparations du jour


        //TODO - afficher l'ensemble des vandalimes du jour


        return $this->render('admin/index.html.twig', [
             'bikes' => $bikes,
             'unavalableBikes' => $unavalableBikes,
             'todayInventories' => $todayInventories,
             'todayBalances' => $todayBalances,
        ]);
    }
}
