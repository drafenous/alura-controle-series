@extends('layout')

@section('cabecalho')
Adicionar Séries
@endsection

@section('conteudo')

@include('errors', ['errors' => $errors])

<form method="post">
    @csrf
    <div class="row">
        <div class="col-md-8">
            <div class="form-group">
                <label for="nome">Nome</label>
                <input type="text" class="form-control" id="nome" name="nome">
            </div>
        </div>

        <div class="col-md-2">
            <div class="form-group">
                <label for="qtd_temporadas">Nº De Temporadas</label>
                <input type="number" class="form-control" id="qtd_temporadas" name="qtd_temporadas">
            </div>
        </div>

        <div class="col-md-2">
            <div class="form-group">
                <label for="qtd_episodios">Nº de Episódios</label>
                <input type="number" class="form-control" id="qtd_episodios" name="qtd_episodios">
            </div>
        </div>
    </div>

    <button class="btn btn-primary">Adicionar</button>
</form>
@endsection