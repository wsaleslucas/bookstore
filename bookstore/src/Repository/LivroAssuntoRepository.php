<?php

namespace App\Repository;

use App\Entity\LivroAssunto;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<LivroAssunto>
 *
 * @method LivroAssunto|null find($id, $lockMode = null, $lockVersion = null)
 * @method LivroAssunto|null findOneBy(array $criteria, array $orderBy = null)
 * @method LivroAssunto[]    findAll()
 * @method LivroAssunto[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LivroAssuntoRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, LivroAssunto::class);
    }

}
