<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Juego - Servant Secreto</title>
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            height: 100vh;
            margin: 0;
            background-color: #f0f0f0;
            font-family: Arial, sans-serif;
        }
        .search-container {
            text-align: center;
        }
        .search-input {
            padding: 10px;
            width: 300px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
        }
        .search-button {
            padding: 10px 15px;
            border: none;
            border-radius: 5px;
            background-color: #007BFF;
            color: white;
            font-size: 16px;
            cursor: pointer;
            margin-left: 5px;
        }
        .search-button:hover {
            background-color: #0056b3;
        }
        .alert {
            margin-top: 20px;
            padding: 10px;
            border-radius: 5px;
            color: white;
        }
        .alert-success {
            background-color: green; 
        }
        .alert-error {
            background-color: red; 
        }
        .result-table {
            margin-top: 20px;
            width: 100%;
            border-collapse: collapse;
        }
        .result-table th, .result-table td {
            border: 1px solid #ccc;
            padding: 10px;
            text-align: left;
        }
        .result-table th {
            background-color: #f2f2f2;
        }
    </style>
</head>

<body>
    @foreach (session('resultados', []) as $resultado)
    @if ($resultado['resultado'] === 'Correcto')
        <tr>
            <td>{{ $resultado['resultado'] }}</td>
        </tr>
    @endif
@endforeach

    @if (session('error'))
    <div class="error-message">
        {{ session('error') }}
    </div>
@endif

<div class="secreto-container">
    <h2>Personaje Secreto (Depuración):</h2>
    <p>Nombre: {{ $personajeSecreto->name }}</p>
    <p>Clase: {{ $personajeSecreto->className }}</p>
    <p>Rareza: {{ $personajeSecreto->rarity }}</p>
</div>

<?php
$acertado = false;
foreach (session('resultados', []) as $resultado) {
    if ($resultado['resultado'] === 'Correcto') {
        $acertado = true;
        break;
    }
}
?>

@if (!$acertado)
<div class="search-container">
    <form action="{{ route('comprobar') }}" method="POST">
        @csrf
        <input type="text" name="nombre" class="search-input" placeholder="Introduce el nombre del personaje" required>
        <button type="submit" class="search-button">Probar</button>
    </form>
</div>
@else
<div class="success-message">
    <h2>¡Has acertado el personaje!</h2>
</div>
@endif
    

    <table class="result-table">
        <thead>
            <tr>
                <th>Servant</th>
                <th>Gender</th>
                <th>Class</th>
                <th>Rarity</th>
                <th>Attribute</th>
                <th>NP Type</th>
                <th>NP Range</th>
            </tr>
        </thead>
        <tbody>
            @foreach (session('resultados', []) as $resultado)
                <tr>
                    <td><img src="{{ $resultado['atributos']->faceImg }}" alt="Imagen" style="max-width: 100px; height: auto; display: block; margin: auto;">
                    </td>
                    <td>{{ $resultado['atributos']->gender }}</td>
                    <td>{{ $resultado['atributos']->className }}</td>
                    <td>{{ $resultado['atributos']->rarity }}</td>
                    <td>{{ $resultado['atributos']->attribute }}</td>
                    <td>{{ $resultado['atributos']->noblePhantasmCard }}</td>
                    <td>{{ $resultado['atributos']->noblePhantasmEffect }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

</body>
</html>