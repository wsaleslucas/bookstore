<?php

namespace App\Tests\Service;

use App\Entity\Assunto;
use App\Entity\Autor;
use App\Entity\Livro;
use App\Entity\LivroAssunto;
use App\Entity\LivroAutor;
use App\Service\CriarLivro;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectRepository;
use PHPUnit\Framework\TestCase;

class CriarLivroTest extends TestCase
{
    private $criarLivro;
    private $entityManagerMock;

    protected function setUp(): void
    {
        $this->entityManagerMock = \Mockery::mock(EntityManagerInterface::class);
        $this->entityManagerMock->shouldReceive('persist');
        $this->entityManagerMock->shouldReceive('flush');
        $this->entityManagerMock->shouldReceive('getConnection')->andReturn($this->getConnectionMock());

        $this->criarLivro = new CriarLivro($this->entityManagerMock);
    }

    public function testCriarLivroSucesso()
    {
        $livroInfo = [
            'titulo' => 'Test Book',
            'editora' => 'Test Publisher',
            'edicao' => '1ª',
            'anoPublicacao' => 2023,
            'autores' => [1, 2],
            'assuntos' => [1, 2],
        ];

        $autorMock1 = $this->createMock(Autor::class);
        $autorMock2 = $this->createMock(Autor::class);
        $assuntoMock1 = $this->createMock(Assunto::class);
        $assuntoMock2 = $this->createMock(Assunto::class);

        $autorRepositoryMock = $this->createMock(ObjectRepository::class);
        $autorRepositoryMock->method('find')->willReturnOnConsecutiveCalls($autorMock1, $autorMock2);

        $assuntoRepositoryMock = $this->createMock(ObjectRepository::class);
        $assuntoRepositoryMock->method('find')->willReturnOnConsecutiveCalls($assuntoMock1, $assuntoMock2);

        $this->entityManagerMock->shouldReceive('getRepository')->with(Autor::class)->andReturn($autorRepositoryMock);
        $this->entityManagerMock->shouldReceive('getRepository')->with(Assunto::class)->andReturn($assuntoRepositoryMock);

        $this->criarLivro->criar($livroInfo);

        $this->assertEquals("SUCESSO", $this->criarLivro->getStatus());
        $this->assertEquals("Livro criado com sucesso!", $this->criarLivro->getMensagem());
    }

    public function testCriarLivroErro()
    {
        $livroInfo = [
            'titulo' => 'Test Book',
            'editora' => 'Test Publisher',
            'edicao' => '1ª',
            'anoPublicacao' => 2023,
            'autores' => [1],
            'assuntos' => [1],
        ];

        $this->entityManagerMock->shouldReceive('flush')
            ->with(\Doctrine\DBAL\Connection::class)
            ->andReturn(new \Exception('Flush error'));

        $this->criarLivro->criar($livroInfo);
        $this->assertEquals("ERRO", $this->criarLivro->getStatus());
        $this->assertEquals("Erro ao criar livro", $this->criarLivro->getMensagem());
    }

    private function getConnectionMock()
    {
        $connectionMock = \Mockery::mock(\Doctrine\DBAL\Connection::class);
        $connectionMock->shouldReceive('beginTransaction');
        $connectionMock->shouldReceive('commit');
        $connectionMock->shouldReceive('rollBack');

        return $connectionMock;
    }
}
