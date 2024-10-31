<?php

namespace App\Repository;

use App\Entity\Livro;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Livro>
 *
 * @method Livro|null find($id, $lockMode = null, $lockVersion = null)
 * @method Livro|null findOneBy(array $criteria, array $orderBy = null)
 * @method Livro[]    findAll()
 * @method Livro[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LivroRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Livro::class);
    }

    public function remove(Livro $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function relatorioLivros($anoInicial = null, $anoFinal = null, $limit = null, $offset = null)
    {
        $condQuery = " 1 = 1";
        if (!empty($anoFinal) && !empty($anoInicial)) {
            $condQuery =  sprintf("vw.ano_publicacao >= '%s' and vw.ano_publicacao <= '%s'", $anoFinal, $anoInicial);
        }

        $offsetQuery = "";
        if(!empty($limit) && $offset !== null) {
            $offsetQuery =  sprintf("LIMIT %s OFFSET %s", $limit, $offset);
        }

        $sql = sprintf("SELECT * FROM vw_relatorio_livros vw WHERE %s ORDER BY vw.cod_au %s", $condQuery, $offsetQuery);
        $stmt = $this->getEntityManager()->getConnection()->prepare($sql);

        $reults = $stmt->executeQuery();
        return $reults->fetchAllAssociative();
    }

}
