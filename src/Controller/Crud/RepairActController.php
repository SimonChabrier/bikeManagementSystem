<?php

namespace App\Controller\Crud;

use App\Entity\RepairAct;
use App\Form\RepairActType;
use App\Repository\RepairActRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/repair/act")
 */
class RepairActController extends AbstractController
{
    /**
     * @Route("/", name="app_repair_act_index", methods={"GET"})
     */
    public function index(RepairActRepository $repairActRepository): Response
    {
        return $this->render('repair_act/index.html.twig', [
            'repair_acts' => $repairActRepository->findBy([],['createdAt' => 'DESC']),
        ]);
    }

    /**
     * @Route("/new", name="app_repair_act_new", methods={"GET", "POST"})
     */
    public function new(Request $request, RepairActRepository $repairActRepository): Response
    {
        $repairAct = new RepairAct();
        $form = $this->createForm(RepairActType::class, $repairAct);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $repairActRepository->add($repairAct);
            return $this->redirectToRoute('app_repair_act_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('repair_act/new.html.twig', [
            'repair_act' => $repairAct,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_repair_act_show", methods={"GET"})
     */
    public function show(RepairAct $repairAct): Response
    {
        return $this->render('repair_act/show.html.twig', [
            'repair_act' => $repairAct,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_repair_act_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, RepairAct $repairAct, RepairActRepository $repairActRepository): Response
    {
        $form = $this->createForm(RepairActType::class, $repairAct);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $repairActRepository->add($repairAct);
            return $this->redirectToRoute('app_repair_act_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('repair_act/edit.html.twig', [
            'repair_act' => $repairAct,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_repair_act_delete", methods={"POST"})
     */
    public function delete(Request $request, RepairAct $repairAct, RepairActRepository $repairActRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$repairAct->getId(), $request->request->get('_token'))) {
            $repairActRepository->remove($repairAct);
        }

        return $this->redirectToRoute('app_repair_act_index', [], Response::HTTP_SEE_OTHER);
    }
}
