<?php

namespace App\Controller;

use App\Entity\Livro;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\CsvEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;


class IndexController extends AbstractController
{
    private $paginator;

    public function __construct(PaginatorInterface $paginator)
    {
        $this->paginator = $paginator;
    }

    /**
     * @Route("/", name="app_index")
     */
    public function index(Request $request): Response
    {
        $query = $this->container->get('doctrine')->getManager()
            ->getRepository(Livro::class)
            ->relatorioLivros();

        $pagination =  $this->paginator->paginate($query, $request->query->getInt('page', 1),3);

        return $this->render('index/index.html.twig', [
            'controller_name' => 'IndexController',
            'pagination' => $pagination,
        ]);
    }

    /**
     * @Route("/relatorio", name="app_relatorio_csv")
     */
    public function relatorioCsv(): Response
    {
        $relatorio = $this->container->get('doctrine')->getManager()
            ->getRepository(Livro::class)->relatorioLivros();

        $normalizers = [new ObjectNormalizer()];
        $encoders = new CsvEncoder();
        $serializer = new Serializer($normalizers, [$encoders]);

        $csvContent = $serializer->serialize($relatorio, 'csv');
        file_put_contents('user.csv', $csvContent);

        $response = new Response($csvContent);
        $response->headers->set('Content-Type', 'text/csv');
        $response->headers->set('Content-Disposition', 'attachment; filename="users.csv"');

        return $response;
    }
}
