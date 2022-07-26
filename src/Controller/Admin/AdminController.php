<?php

namespace App\Controller\Admin;

use App\Repository\BikeRepository;
use App\Repository\BalanceRepository;
use App\Repository\InventoryRepository;
use App\Repository\RepairActRepository;
use App\Repository\VandalismRepository;
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
    BalanceRepository $balanceRepository,
    RepairActRepository $repairActRepository,
    VandalismRepository $vandalismRepository): Response
    {

        $allBikes = $bikeRepository->findAll();

        //TODO - afficher l'ensemble des vélos mis à jour aujourd'hui
        $updatedBikes = $bikeRepository->findAllBikesUpdatedToday();

        //TODO - afficher l'ensemble des vélos déclarés indiponibles
        $unavalableBikes = $bikeRepository->findAllbikesUnavalable();

        //TODO - afficher l'ensemble des inventaires du jour
        $todayInventories = $inventoryRepository->findAllInventoriesUpdatedToday();

        //TODO - afficher l'ensemble des équilibrages du jour
        $todayBalances = $balanceRepository->findAllBalancesUpdatedToday();

        //TODO - afficher l'ensemble des réparations du jour
        $todayRepairs = $repairActRepository->findAllRepairsUpdatedToday();
 
        //TODO - afficher l'ensemble des vandalimes du jour
        $todayVandalims = $vandalismRepository->findAllVandalimsUpdatedToday();

        return $this->render('admin/index.html.twig', 
        compact('allBikes',
                'updatedBikes', 
                'unavalableBikes', 
                'todayInventories', 
                'todayBalances', 
                'todayRepairs', 
                'todayVandalims'
                )
            );
        }
}
