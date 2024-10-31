<?php

namespace App\Controller;

use App\Entity\Assunto;
use App\Entity\Autor;
use App\Entity\Livro;
use App\Entity\LivroAssunto;
use App\Entity\LivroAutor;
use App\Form\LivroType;
use App\Service\AlterarLivro;
use App\Service\ApagarLivro;
use App\Service\CriarLivro;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/livro")
 */
class LivroController extends AbstractController
{
    /**
     * @Route("/", name="app_livro_index", methods={"GET"})
     */
    public function index(EntityManagerInterface $entityManager): Response
    {
        $livros = $entityManager->getRepository(Livro::class)->findAll();

        return $this->render('livro/index.html.twig', [
            'livros' => $livros,
        ]);
    }

    /**
     * @Route("/new", name="app_livro_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $livro = new Livro();
        $form = $this->createForm(LivroType::class, $livro);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            $criarLivro = new CriarLivro($entityManager);
            $criarLivro->criar($request->request->get('livro'));
            return $this->redirectToRoute(
                'app_livro_index',[
                    'message' => $criarLivro->getMensagem(),
                    'status' => $criarLivro->getStatus()
                ],
                Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('livro/new.html.twig', [
            'livro' => $livro,
            'form' => $form,
            'autores' => $entityManager->getRepository(Autor::class)->findAll(),
            'assuntos' => $entityManager->getRepository(Assunto::class)->findAll(),
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_livro_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Livro $livro, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(LivroType::class, $livro);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            $alterarLivro = new AlterarLivro($entityManager);
            $alterarLivro->upade($livro, $request->request->get('livro'));

            return $this->redirectToRoute(
                'app_livro_index', [
                'message' => $alterarLivro->getMensagem(),
                'status' => $alterarLivro->getStatus()
            ],
                Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('livro/edit.html.twig', [
            'livro' => $livro,
            'form' => $form,
            'autoresSel' => $entityManager->getRepository(LivroAutor::class)->findBy(['livroCod' => $livro->getCod()]),
            'assuntosSel' => $entityManager->getRepository(LivroAssunto::class)->findBy(['livroCod' => $livro->getCod()]),
            'autores' => $entityManager->getRepository(Autor::class)->findAll(),
            'assuntos' => $entityManager->getRepository(Assunto::class)->findAll()

        ]);
    }

    /**
     * @Route("/delete/{id}", name="app_livro_delete", methods={"GET", "POST"}, options={"expose"=true})
     */
    public function delete(Request $request, Livro $livro, EntityManagerInterface $entityManager): Response
    {
        $response = new Response();
        try {
            $apagarLivro = new ApagarLivro($entityManager);
            $apagarLivro->apagar($livro);

            $response->setStatusCode(Response::HTTP_OK);
            $response->setContent('Livro removido com sucesso!');
        } catch (\Exception $e) {
            $response->setStatusCode(Response::HTTP_BAD_REQUEST);
            $response->setContent('Nao foi possivel remover o Livro: ');
            dump($e);
            exit;
        }

        return new JsonResponse([
            'code' => $response->getStatusCode(),
            'message' => $response->getContent()
        ]);
    }

}
