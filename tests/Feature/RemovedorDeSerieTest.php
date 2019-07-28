<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Services\RemovedorDeSerie;
use App\Services\CriadorDeSerie;

class RemovedorDeSerieTest extends TestCase
{
    use RefreshDatabase;
    private $serie;
    public function setUp(): void{
        parent::setUp();
        $criadorDeSerie = new CriadorDeSerie();
        $this->serie = $criadorDeSerie->criarSerie('Nome da Série', 1, 1);
    }
    public function testRemoverUmaSerie()
    {
        $removedorDeSerie = new RemovedorDeSerie();
        $nome = $removedorDeSerie->removeSerie($this->serie->id);
        $this->assertIsString($nome);
        $this->assertEquals('Nome da Série', $this->serie->nome);
        $this->assertDatabaseMissing('series', ['id' => $this->serie->id]);
    }
}
