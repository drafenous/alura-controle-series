<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Serie;
use App\Temporada;
use App\Episodio;
use App\Http\Requests\SeriesFormRequest;
use App\Services\CriadorDeSerie;
use App\Services\RemovedorDeSerie;
use Illuminate\Support\Facades\Auth;

class SeriesController extends Controller
{
    public function index(Request $request)
    {

        $series = Serie::query()->orderBy('nome')->get();

        $mensagem = $request->session()->get('mensagem'); // Lê a sessão
        $request->session()->remove('mensagem'); // Remove a sessão

        // return view('series.index', compact('series')); // É o mesmo que a linha abaixo
        return view('series.index', ['series' => $series, 'mensagem' => $mensagem]);
    }

    public function create()
    {
        return view('series.create');
    }

    public function store(
        SeriesFormRequest $request,
        CriadorDeSerie $criadorDeSerie
        )
    {

        // if(!isset($request->nome) || strlen($request->nome) < 3){
        //     return redirect()->route('form_criar_serie');
        // } // Valida em PHP puro os dados recebidos.

        // $request->validate([
        //     'nome' => 'required|min:3'
        // ]); // Valida os dados recebidos, a regras são separadas por pipe. Na aula é mostrado como é feito a validação por método de FormRequests.

        // $nome = $request->get('nome'); // É o mesmo que a linha abaixo
        $nome = $request->nome;

        // $serie = new Serie();
        // $serie->nome = $nome;
        // var_dump($serie->save()); 
        // É o mesmo que o código representado abaixo
        // $serie = Serie::create([
        //     'nome' => $nome
        // ]);
        // ou a linha abaixo

        $serie = $criadorDeSerie->criarSerie($nome, $request->qtd_temporadas, $request->qtd_episodios);

        // $request->session()->put('mensagem', "Série {$serie->id} criada com sucesso: {$serie->nome}"); // Cria a sessão
        $request->session()->flash('mensagem', "Série {$serie->id} e suas temporadas e episódios criada com sucesso: {$serie->nome}"); // Cria a sessão e assim que é lida novamente já exclui.

        return redirect()->route('index');
    }

    public function destroy(Request $request, RemovedorDeSerie $removedorDeSerie)
    {
        $nomeSerie = $removedorDeSerie->removeSerie($request->id);
        
        $request->session()->flash('mensagem', "Série {$nomeSerie} removida com sucesso."); // Cria a sessão e assim que é lida novamente já exclui.

        return redirect()->route('index');
    }

    public function editaNome(int $id, Request $request){
        $novoNome = $request->nome;
        $serie = Serie::find($id);
        $serie->nome = $novoNome;
        $serie->save();
    }
}
