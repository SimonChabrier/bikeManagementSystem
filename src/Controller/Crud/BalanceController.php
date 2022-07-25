<?php

namespace App\Controller\Crud;

use App\Entity\Balance;
use App\Entity\Station;
use App\Form\BalanceType;
use App\Repository\BalanceRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/balance")
 */
class BalanceController extends AbstractController
{
    /**
     * @Route("/", name="app_balance_index", methods={"GET"})
     */
    public function index(BalanceRepository $balanceRepository): Response
    {
        return $this->render('balance/index.html.twig', [
            'balances' => $balanceRepository->findBy([],['createdAt'=> 'DESC']),
            //'balances' => $balanceRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="app_balance_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $manager): Response
    {
        $balance = new Balance();
        $form = $this->createForm(BalanceType::class, $balance);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

                $stationPickUp = $form['stationPickUp']->getData();
                $stationDelivery = $form['stationDelivery']->getData();

                if($stationPickUp === $stationDelivery) 
                {
                    $this->addFlash('error', 'La station d\'enlèvement ne peut pas être la même que la station de destination !');
                    return $this->redirectToRoute('app_balance_new', [], Response::HTTP_SEE_OTHER);
                }

                else {
                $balance->addStation($stationPickUp);
                $balance->addStation($stationDelivery);

                $manager->persist($balance);
                $manager->flush();
                }
           
            return $this->redirectToRoute('app_balance_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('balance/new.html.twig', [
            'balance' => $balance,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_balance_show", methods={"GET"})
     */
    public function show(Balance $balance): Response
    {
        return $this->render('balance/show.html.twig', [
            'balance' => $balance,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_balance_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Balance $balance, Station $station, EntityManagerInterface $manager): Response
    {   

        $form = $this->createForm(BalanceType::class, $balance);
        $form->handleRequest($request);
      
        if ($form->isSubmitted() && $form->isValid()) {

            // get stations collection from $balance Id
            $stations = $balance->getStations();

                //Clean the current balanced values before update
                if ($stations) {
                    foreach ($stations as $station) {
                        $station->removeBalance($balance);
                        $manager->flush();
                    }
                }

                //Get the new submited values   
                $stationPickUp = $form['stationPickUp']->getData();
                $stationDelivery = $form['stationDelivery']->getData();
            
                //Unautorize choice the same station in form fields  
                if($stationPickUp === $stationDelivery) 
                {
                    $this->addFlash('error', 'La station d\'enlèvement ne peut pas être la même que la station de destination !');
                    return $this->redirectToRoute('app_balance_new', [], Response::HTTP_SEE_OTHER);
                }

                //If stations choices are different, persist new balance state 
                else {
                $balance->addStation($stationPickUp);
                $balance->addStation($stationDelivery);

                $manager->flush();
                }

            return $this->redirectToRoute('app_balance_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('balance/edit.html.twig', [
            'balance' => $balance,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_balance_delete", methods={"POST"})
     */
    public function delete(Request $request, Balance $balance, BalanceRepository $balanceRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$balance->getId(), $request->request->get('_token'))) {
            $balanceRepository->remove($balance);
        }

        return $this->redirectToRoute('app_balance_index', [], Response::HTTP_SEE_OTHER);
    }
}