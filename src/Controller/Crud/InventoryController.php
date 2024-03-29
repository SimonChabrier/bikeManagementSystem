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
use Symfony\Component\VarExporter\Internal\Values;

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

            $manager->persist($inventory);
            $manager->flush();

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
