<?php

namespace App\Services;

use App\{Serie, Temporada, Episodio};
use Illuminate\Support\Facades\DB;

class CriadorDeSerie
{
    public function criarSerie(string $nomeSerie,
     int $qtdTemporadas,
     int $qtdEpisodios): Serie
    {
        DB::beginTransaction();
        $serie = Serie::create(['nome' => $nomeSerie]);
        $this->criarTemporada($qtdTemporadas, $serie, $qtdEpisodios);
        DB::commit();

        return $serie;
    }

    private function criarTemporada(int $qtdTemporadas, Serie $serie, int $qtdEpisodios){
        for ($i = 1; $i <= $qtdTemporadas; $i++) {
            $temporada = $serie->temporadas()->create(['numero' => $i]);
            $this->criarEpisodio($qtdEpisodios, $temporada);
        }
    }

    private function criarEpisodio(int $qtdEpisodios, Temporada $temporada){
        for ($j = 1; $j <= $qtdEpisodios; $j++) {
            $temporada->episodios()->create(['numero' => $j]);
        }
    }
}
