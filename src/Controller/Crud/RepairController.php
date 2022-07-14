<?php

namespace App\Controller\Crud;

use App\Entity\Repair;
use App\Form\RepairType;
use App\Repository\RepairRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/repair")
 */
class RepairController extends AbstractController
{
    /**
     * @Route("/", name="app_repair_index", methods={"GET"})
     */
    public function index(RepairRepository $repairRepository): Response
    {
        return $this->render('repair/index.html.twig', [
            'repairs' => $repairRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="app_repair_new", methods={"GET", "POST"})
     */
    public function new(Request $request, RepairRepository $repairRepository): Response
    {
        $repair = new Repair();
        $form = $this->createForm(RepairType::class, $repair);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $repairRepository->add($repair);
            return $this->redirectToRoute('app_repair_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('repair/new.html.twig', [
            'repair' => $repair,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_repair_show", methods={"GET"})
     */
    public function show(Repair $repair): Response
    {
        return $this->render('repair/show.html.twig', [
            'repair' => $repair,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_repair_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Repair $repair, RepairRepository $repairRepository): Response
    {
        $form = $this->createForm(RepairType::class, $repair, ['edit_mode' => true ]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $repairRepository->add($repair);
            return $this->redirectToRoute('app_repair_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('repair/edit.html.twig', [
            'repair' => $repair,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_repair_delete", methods={"POST"})
     */
    public function delete(Request $request, Repair $repair, RepairRepository $repairRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$repair->getId(), $request->request->get('_token'))) {
            $repairRepository->remove($repair);
        }

        return $this->redirectToRoute('app_repair_index', [], Response::HTTP_SEE_OTHER);
    }
}
