<?php

namespace App\Controller\Crud;

use App\Entity\Inventory;
use App\Form\InventoryType;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\InventoryRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/inventory")
 */
class InventoryController extends AbstractController
{
    /**
     * @Route("/", name="app_inventory_index", methods={"GET"})
     */
    public function index(InventoryRepository $inventoryRepository): Response
    {   

        return $this->render('inventory/index.html.twig', [
            'inventories' => $inventoryRepository->findAllOrderedByDESC(),
        ]);
    }

    /**
     * @Route("/new", name="app_inventory_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $manager): Response
    {
        $inventory = new Inventory();
        $form = $this->createForm(InventoryType::class, $inventory);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            //ici j'ai la station je la passe à l'inventaire
            $station = $form['station']->getData();
            $station->addInventory($inventory);
            $manager->persist($station);

            //j'ai des objets vélo je boucle dessus pour associer chaque vélo à l'inventaire
            $bikes = $form['bikes']->getData();
            foreach($bikes as $bike){
                $inventory->addBike($bike);
                $manager->persist($inventory);
            }

            $manager->flush();
            //ici j'ajoute l'inventaire soummis avec le numéro de station
            //$inventoryRepository->add($inventory);

            return $this->redirectToRoute('app_inventory_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('inventory/new.html.twig', [
            'inventory' => $inventory,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_inventory_show", methods={"GET"})
     */
    public function show(Inventory $inventory): Response
    {
        dump($inventory);

        return $this->render('inventory/show.html.twig', [
            'inventory' => $inventory,
            
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_inventory_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Inventory $inventory, InventoryRepository $inventoryRepository): Response
    {
        $form = $this->createForm(InventoryType::class, $inventory);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $inventoryRepository->add($inventory);
            return $this->redirectToRoute('app_inventory_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('inventory/edit.html.twig', [
            'inventory' => $inventory,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_inventory_delete", methods={"POST"})
     */
    public function delete(Request $request, Inventory $inventory, InventoryRepository $inventoryRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$inventory->getId(), $request->request->get('_token'))) {
            $inventoryRepository->remove($inventory);
        }

        return $this->redirectToRoute('app_inventory_index', [], Response::HTTP_SEE_OTHER);
    }
}
