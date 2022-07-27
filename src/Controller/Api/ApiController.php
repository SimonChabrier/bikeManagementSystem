<?php

namespace App\Controller\Api;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ApiController extends AbstractController
{
    /**
     * @Route("/temp/api", name="app_main_api")
     */
    public function index(): Response
    {
        return new Response (

            '
            <h1>Future route API controller</h1>
            </div>
            '     
        );
        // return $this->render('api/index.html.twig', [
        //     'controller_name' => 'ApiController',
        // ]);
    }
}
