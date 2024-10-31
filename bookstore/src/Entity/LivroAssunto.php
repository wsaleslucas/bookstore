<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * LivroAssunto
 *
 * @ORM\Table(name="livro_assunto", indexes={@ORM\Index(name="livro_assunto_assunto_FK", columns={"assunt_cod_as"}), @ORM\Index(name="livro_assunto_livro_FK", columns={"livro_cod"})})
 * @ORM\Entity
 */
class LivroAssunto
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
     * @var Livro
     *
     * @ORM\ManyToOne(targetEntity="Livro")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="livro_cod", referencedColumnName="cod")
     * })
     */
    private $livroCod;

    /**
     * @var \Assunto
     *
     * @ORM\ManyToOne(targetEntity="Assunto")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="assunt_cod_as", referencedColumnName="cod_as")
     * })
     */
    private $assuntCodAs;

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

    /**
     * @return \Assunto
     */
    public function getAssuntCodAs()
    {
        return $this->assuntCodAs;
    }

    /**
     * @param \Assunto $assuntCodAs
     */
    public function setAssuntCodAs($assuntCodAs)
    {
        $this->assuntCodAs = $assuntCodAs;
    }

}
