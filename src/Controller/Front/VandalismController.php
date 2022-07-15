<?php

namespace App\Controller\Front;

use App\Entity\Vandalism;
use App\Form\VandalismType;
use App\Repository\VandalismRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/vandalism")
 */
class VandalismController extends AbstractController
{
    /**
     * @Route("/", name="app_vandalism_index", methods={"GET"})
     */
    public function index(VandalismRepository $vandalismRepository): Response
    {   

        return $this->render('vandalism/index.html.twig', [
            'vandalisms' => $vandalismRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="app_vandalism_new", methods={"GET", "POST"})
     */
    public function new(Request $request, VandalismRepository $vandalismRepository): Response
    {
        $vandalism = new Vandalism();
        $form = $this->createForm(VandalismType::class, $vandalism);  
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $vandalismRepository->add($vandalism);
            return $this->redirectToRoute('app_vandalism_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('vandalism/new.html.twig', [
            'vandalism' => $vandalism,
            'form' => $form,
        ]);

    }
}
