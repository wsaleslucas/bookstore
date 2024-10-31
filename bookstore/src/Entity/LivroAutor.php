<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * LivroAutor
 *
 * @ORM\Table(name="livro_autor", indexes={@ORM\Index(name="livro_autor_livro_FK", columns={"livro_cod"}), @ORM\Index(name="livro_autor_autor_FK", columns={"autor_cod_au"})})
 * @ORM\Entity
 */
class LivroAutor
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var Autor
     *
     * @ORM\ManyToOne(targetEntity="Autor")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="autor_cod_au", referencedColumnName="cod_au")
     * })
     */
    private $autorCodAu;

    /**
     * @var Livro
     *
     * @ORM\ManyToOne(targetEntity="Livro")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="livro_cod", referencedColumnName="cod")
     * })
     */
    private $livroCod;

    /**
     * @return Autor
     */
    public function getAutorCodAu()
    {
        return $this->autorCodAu;
    }

    /**
     * @param Autor $autorCodAu
     */
    public function setAutorCodAu($autorCodAu)
    {
        $this->autorCodAu = $autorCodAu;
    }

    /**
     * @return Livro
     */
    public function getLivroCod()
    {
        return $this->livroCod;
    }

    /**
     * @param Livro $livroCod
     */
    public function setLivroCod($livroCod)
    {
        $this->livroCod = $livroCod;
    }
}
