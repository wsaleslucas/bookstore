<?php

namespace App\Entity;

use App\Repository\AutorRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=AutorRepository::class)
 */
class Autor
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @ORM\Column(name="cod_au", type="integer", nullable=false)
     */
    private $cod_au;

    /**
     * @ORM\Column(type="string", length=40)
     */
    private $nome;

    public function getCodAu(): ?int
    {
        return $this->cod_au;
    }

    public function getNome(): ?string
    {
        return $this->nome;
    }

    public function setNome(string $nome): self
    {
        $this->nome = $nome;

        return $this;
    }
}
