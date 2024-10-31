<?php

namespace App\Controller;

use App\Entity\Autor;
use App\Form\AutorType;
use App\Repository\AutorRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/autor")
 */
class AutorController extends AbstractController
{
    /**
     * @Route("/", name="app_autor_index", methods={"GET"})
     */
    public function index(EntityManagerInterface $entityManager): Response
    {
        $autors = $entityManager
            ->getRepository(Autor::class)
            ->findAll();

        return $this->render('autor/index.html.twig', [
            'autores' => $autors,
        ]);
    }

    /**
     * @Route("/new", name="app_autor_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $autor = new Autor();
        $form = $this->createForm(AutorType::class, $autor);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($autor);
            $entityManager->flush();

            return $this->redirectToRoute('app_autor_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('autor/new.html.twig', [
            'autor' => $autor,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_autor_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Autor $autor, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(AutorType::class, $autor);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_autor_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('autor/edit.html.twig', [
            'autor' => $autor,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/delete/{id}", name="app_autor_delete", methods={"POST"}, options={"expose"=true})
     */
    public function delete(Request $request, Autor $autor, AutorRepository $autorRepository): Response
    {
        $response = new Response();
        try {
            $autorRepository->remove($autor, true);
            $response->setStatusCode(Response::HTTP_OK);
            $response->setContent('Autor removido com sucesso!');
        } catch (\Exception $e) {
            $response->setStatusCode(Response::HTTP_BAD_REQUEST);
            $response->setContent('Nao foi possivel remover o Autor: ');
        }

        return new JsonResponse([
            'code' => $response->getStatusCode(),
            'message' => $response->getContent()
        ]);
    }

}
