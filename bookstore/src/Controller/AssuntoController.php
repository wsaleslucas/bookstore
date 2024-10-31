<?php

namespace App\Controller;

use App\Entity\Assunto;
use App\Form\AssuntoType;
use App\Repository\AssuntoRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/assunto")
 */
class AssuntoController extends AbstractController
{
    /**
     * @Route("/", name="app_assunto_index", methods={"GET"})
     */
    public function index(AssuntoRepository $assuntoRepository): Response
    {
        return $this->render('assunto/index.html.twig', [
            'assuntos' => $assuntoRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="app_assunto_new", methods={"GET", "POST"})
     */
    public function new(Request $request, AssuntoRepository $assuntoRepository): Response
    {
        $assunto = new Assunto();
        $form = $this->createForm(AssuntoType::class, $assunto);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $assuntoRepository->add($assunto, true);
            return $this->redirectToRoute('app_assunto_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('assunto/new.html.twig', [
            'assunto' => $assunto,
            'form' => $form,
        ]);
    }


    /**
     * @Route("/{id}/edit", name="app_assunto_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Assunto $assunto, AssuntoRepository $assuntoRepository): Response
    {
        $form = $this->createForm(AssuntoType::class, $assunto);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $assuntoRepository->add($assunto, true);

            return $this->redirectToRoute('app_assunto_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('assunto/edit.html.twig', [
            'assunto' => $assunto,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/delete/{id}", name="app_assunto_delete", methods={"POST"},  options={"expose"=true})
     */
    public function delete(Request $request, Assunto $assunto, AssuntoRepository $assuntoRepository): JsonResponse
    {
        $response = new Response();
        try {
            $assuntoRepository->remove($assunto, true);
            $response->setStatusCode(Response::HTTP_OK);
            $response->setContent('Assunto removido com sucesso!');
        } catch (\Exception $e) {
            $response->setStatusCode(Response::HTTP_BAD_REQUEST);
            $response->setContent('Nao foi possivel remover o assunto: ' . $e->getMessage());
        }

        return new JsonResponse([
            'code' => $response->getStatusCode(),
            'message' => $response->getContent()
        ]);
    }
}
