<?php

namespace App\Service;

use App\Entity\Assunto;
use App\Entity\Autor;
use App\Entity\Livro;
use App\Entity\LivroAssunto;
use App\Entity\LivroAutor;

class CriarLivro extends LivroBase
{
    public function criar($livroInfo = [])
    {
        $this->status = "SUCESSO";
        $this->em->getConnection()->beginTransaction();
        try {
            $livro = new Livro();
            $livro->setTitulo(trim($livroInfo["titulo"]));
            $livro->setEditora($livroInfo["editora"]);
            $livro->setEdicao($livroInfo["edicao"]);
            $livro->setAnoPublicacao($livroInfo["anoPublicacao"]);
            $this->em->persist($livro);

            foreach ($livroInfo["autores"] as $autor) {
                $livroAutor = new LivroAutor();
                $livroAutor->setAutorCodAu($this->em->getRepository(Autor::class)->find($autor));
                $livroAutor->setLivroCod($livro);
                $this->em->persist($livroAutor);
            }

            foreach ($livroInfo["assuntos"] as $assunto) {
                $livroAssunto = new LivroAssunto();
                $livroAssunto->setLivroCod($livro);
                $livroAssunto->setAssuntCodAs($this->em->getRepository(Assunto::class)->find($assunto));
                $this->em->persist($livroAssunto);
            }

            $this->em->flush();
            $this->em->getConnection()->commit();
            $this->mensagem = "Livro criado com sucesso!";
        } catch (\Exception $exception) {
            $this->em->getConnection()->rollBack();
            $this->status = "ERRO";
            $this->mensagem = "Erro ao criar livro";
        }
    }
}