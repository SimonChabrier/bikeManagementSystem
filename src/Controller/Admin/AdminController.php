<?php

namespace App\Controller\Admin;

use App\Repository\BikeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


/**
 * @Route("/admin")
 */
class AdminController extends AbstractController
{
    /**
     * @Route("/", name="app_admin_index")
     */
    public function index(BikeRepository $bikeRepository): Response
    {
        return $this->render('admin/index.html.twig', [
            'bikes' => $bikeRepository->findAll(),
        ]);
    }
}
