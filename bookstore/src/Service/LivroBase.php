<?php

namespace App\Service;

use App\Entity\Livro;
use App\Entity\LivroAssunto;
use App\Entity\LivroAutor;
use Doctrine\ORM\EntityManagerInterface;

class LivroBase
{
    protected $em;
    protected $mensagem;
    protected $status;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->em = $entityManager;
    }

    /**
     * @param Livro $livro
     * @return void
     */
    public function limparLivroAutor(Livro $livro)
    {
        $livroAutores =  $this->em->getRepository(LivroAutor::class)->findBy(['livroCod' => $livro->getCod()]);
        foreach ($livroAutores as $livroAutor) {
            $this->em->remove($livroAutor);
        }
    }

    /**
     * @param Livro $livro
     * @return void
     */
    public function limparLivroAssunto(Livro $livro)
    {
        $livroAssuntos =  $this->em->getRepository(LivroAssunto::class)->findBy(['livroCod' => $livro->getCod()]);
        foreach ($livroAssuntos as $livroAssunto) {
            $this->em->remove($livroAssunto);
        }
    }

    /**
     * @return mixed
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @return mixed
     */
    public function getMensagem()
    {
        return $this->mensagem;
    }

    public function __destruct() {}
}