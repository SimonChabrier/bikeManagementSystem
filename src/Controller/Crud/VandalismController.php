<?php

namespace App\Controller\Crud;

use App\Entity\Vandalism;
use App\Form\VandalismType;
use App\Service\MainPictureUploader;
use App\Repository\VandalismRepository;
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
            'vandalisms' => $vandalismRepository->findBy([],['createdAt' => 'DESC']),
        ]);
    }

    /**
     * @Route("/new", name="app_vandalism_new", methods={"GET", "POST"})
     */
    public function new(Request $request, VandalismRepository $vandalismRepository, MainPictureUploader $MainPictureUploader): Response
    {
        $vandalism = new Vandalism();
        $form = $this->createForm(VandalismType::class, $vandalism);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $mainPictureFile = $form->get('mainPicture')->getData();
            if ($mainPictureFile) {
                $mainPicture = $MainPictureUploader->uploadPictureService($mainPictureFile);
                $vandalism->setMainPicture($mainPicture);   
            }

            $vandalismRepository->add($vandalism);
            return $this->redirectToRoute('app_vandalism_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('vandalism/new.html.twig', [
            'vandalism' => $vandalism,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_vandalism_show", methods={"GET"})
     */
    public function show(Vandalism $vandalism): Response
    {
        return $this->render('vandalism/show.html.twig', [
            'vandalism' => $vandalism,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_vandalism_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Vandalism $vandalism, VandalismRepository $vandalismRepository, MainPictureUploader $MainPictureUploader): Response
    {
        $form = $this->createForm(VandalismType::class, $vandalism);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $mainPictureFile = $form->get('mainPicture')->getData();
            if ($mainPictureFile) {
                $mainPicture = $MainPictureUploader->uploadPictureService($mainPictureFile);
                $vandalism->setMainPicture($mainPicture);   
            }

            $vandalismRepository->add($vandalism);
            return $this->redirectToRoute('app_vandalism_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('vandalism/edit.html.twig', [
            'vandalism' => $vandalism,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_vandalism_delete", methods={"POST"})
     */
    public function delete(Request $request, Vandalism $vandalism, VandalismRepository $vandalismRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$vandalism->getId(), $request->request->get('_token'))) {
            $vandalismRepository->remove($vandalism);
        }

        return $this->redirectToRoute('app_vandalism_index', [], Response::HTTP_SEE_OTHER);
    }
}
