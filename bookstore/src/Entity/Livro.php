<?php

namespace App\Entity;

use App\Repository\LivroRepository;
use Doctrine\ORM\Mapping as ORM;


/**
 * CriarLivro
 *
 * @ORM\Table(name="livro")
 * @ORM\Entity(repositoryClass=LivroRepository::class)
 */
class Livro
{
    /**
     * @var int
     *
     * @ORM\Column(name="cod", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $cod;

    /**
     * @var string
     *
     * @ORM\Column(name="titulo", type="string", length=40, nullable=false)
     */
    private $titulo;

    /**
     * @var string
     *
     * @ORM\Column(name="editora", type="string", length=40, nullable=false)
     */
    private $editora;

    /**
     * @var int|null
     *
     * @ORM\Column(name="edicao", type="integer", nullable=true)
     */
    private $edicao;

    /**
     * @var string
     *
     * @ORM\Column(name="ano_publicacao", type="string", length=4, nullable=false)
     */
    private $anoPublicacao;

    /**
     * @var float
     * @ORM\Column(name="preco", type="float", nullable=true)
     */
    private $preco;

    /**
     * @return int
     */
    public function getCod()
    {
        return $this->cod;
    }

    /**
     * @return string
     */
    public function getTitulo()
    {
        return $this->titulo;
    }

    /**
     * @param string $titulo
     */
    public function setTitulo($titulo)
    {
        $this->titulo = $titulo;
    }

    /**
     * @return string
     */
    public function getEditora()
    {
        return $this->editora;
    }

    /**
     * @param string $editora
     */
    public function setEditora($editora)
    {
        $this->editora = $editora;
    }

    /**
     * @return int|null
     */
    public function getEdicao()
    {
        return $this->edicao;
    }

    /**
     * @param int|null $edicao
     */
    public function setEdicao($edicao)
    {
        $this->edicao = $edicao;
    }

    /**
     * @return string
     */
    public function getAnoPublicacao()
    {
        return $this->anoPublicacao;
    }

    /**
     * @param string $anoPublicacao
     */
    public function setAnoPublicacao($anoPublicacao)
    {
        $this->anoPublicacao = $anoPublicacao;
    }

    public function getPreco()
    {
        return $this->preco;
    }
}
