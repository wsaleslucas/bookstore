<?php

namespace App\Service;
use App\Entity\Livro;

class ApagarLivro extends LivroBase
{
    public function apagar(Livro $livro)
    {
        $this->status = "SUCESSO";
        $this->em->getConnection()->beginTransaction();
        try {
            $this->limparLivroAssunto($livro);
            $this->limparLivroAutor($livro);
            $this->em->remove($livro);
            $this->em->flush();
            $this->em->getConnection()->commit();
            $this->mensagem = "Livro editar com sucesso!";
        } catch (\Exception $exception) {
            $this->em->getConnection()->rollBack();
            $this->status = "ERRO";
            $this->mensagem = "Erro ao editar livro";
        }
    }

}