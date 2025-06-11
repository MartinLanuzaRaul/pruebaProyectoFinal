<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="preload" as="image" href="/images/background.png">
    <title>Fatedle - Classic</title>
    
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            margin: 0;
            background: url('/images/background.png') no-repeat center center fixed;
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            background-attachment: fixed;
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
        
        .tablaServants {
    border-collapse: separate;
    border-spacing: 10px; /
    margin: 0 auto; 
    table-layout: fixed;
    width: auto;
    margin-bottom: 5%;
}
    .give-up-button{
        padding: 10px 15px;
            border: none;
            border-radius: 5px;
            background-color: #da1313;
            color: white;
            font-size: 16px;
            cursor: pointer;
            margin-left: 5px;
            margin-bottom: 5px;
    }
.tablaServants th,
.tablaServants td {
    border: 2px solid #ccc;
    border-radius: 8px;
    text-align: center;
    vertical-align: middle;
    padding: 0;
    width: 100px;
    height: 100px;
    box-sizing: border-box;
    font-size: 12px;
    font-weight: bold;
    overflow: hidden;
}

.tablaServants th {
    background-color: #e0e0e0;
}

.correct {
    background-color: #b6f2b6; 
}

.incorrect {
    background-color: #f8b6b6; 
}

.tablaServants td img {
    width: 100px;
    height: 100px;
    object-fit: cover;
    display: block;
    margin: 0 auto;
}

        
        .caja {
    display: flex;
    justify-content: center;
    align-items: center;
    margin-top: 20px;
    
}

.cajaDentro {
    background-color: #d9d9d9;
    border: 5px solid black;
    padding: 30px;
    display: flex;
    gap: 30px;
    margin-bottom: 10%;
    border-radius: 25px;
}

.textoCaja {
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    text-align: center;
}

.textoCaja h2 {
    margin: 0;
}

.textoCaja p {
    margin: 10px 0;
}

.textoCaja .importante {
    margin-top: 50px;
    font-weight: bold;
}

.result-img {
    max-width: 300px;
    height: auto;
    border: 5px solid black;
    border-radius: 25px;
}

.login {
            position: absolute;
            top: 1rem;
            right: 1rem;
            background: black;
            color: white;
            border: none;
            padding: 0.5rem 1rem;
            cursor: pointer;
        }

        .success-message{
    color: white;
}

    </style>
</head>

<body>
    <a href="{{route('login')}}"><button class="login">Account</button></a>
    <a href="{{route('home')}}"><div class="logo"><img id="logo" src="images/logo.png" height="350px" width="350px"></div></a>

    @if ($stats)
                            

        
         
    @endif
    

    <div class="caja" id="caja">
        <div class="cajaDentro">
            <div class="textoCaja">
                <div>
                    <h2>GUESS SERVANT</h2>
                    <p>type any character to begin</p>
                </div>
            </div>
            
        </div>
    </div>

    

    @if (session('error'))
    <div class="error-message">
        {{ session('error') }}
    </div>
@endif

@if(isset($personajeSecreto))
    <script>
        console.log("Personaje Secreto (Depuración):");
        console.log("Nombre: {{ ($personajeSecreto->name) }}");
        console.log("Clase: {{ ($personajeSecreto->className) }}");
        console.log("Rareza: {{ ($personajeSecreto->rarity) }}");
    </script>
@endif


<?php
$acertado = false;
foreach (session('resultadosIlimitado', []) as $resultado) {
    if ($resultado['resultado'] === 'Correcto') {
        $acertado = true;
        break;
    }
}
?>
<form action="{{ route('rendirse') }}" method="GET">
    <button type="submit" class="give-up-button">Give up</button>
</form>
<br>

@if (!$acertado && !$rendido)
<div class="search-container">
    <form action="{{ route('comprobarIlimitado') }}" method="POST">
        @csrf
        <input type="text" name="nombre" class="search-input" placeholder="Type Servant name..." required autocomplete="off">
        <div id="suggestions" style="margin-top: 10px; text-align: left; width: 300px; position: absolute; background: white; z-index: 999;"></div>

        <button type="submit" class="search-button">Guess</button>
    </form>
</div>
@else
    @if ($acertado)
    <div class="success-message">
        <h2>You got it!</h2>
    </div>
    @endif
@endif

    

    <table class="tablaServants">
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
            @foreach (session('resultadosIlimitado', []) as $resultado)
            <tr>
                <td>
                    <img src="{{ $resultado['atributos']->faceImg }}" alt="Imagen" style="max-width: 100px; height: auto; display: block; margin: auto;">
                </td>
                @if($personajeSecreto->gender != $resultado['atributos']->gender)
                    <td class="incorrect">{{ $resultado['atributos']->gender }}</td>
                @else
                  <td class="correct">{{ $resultado['atributos']->gender }}</td>
                @endif
                @if($personajeSecreto->className != $resultado['atributos']->className)
                    <td class="incorrect">{{ $resultado['atributos']->className }}</td>
                @else
                    <td class="correct">{{ $resultado['atributos']->className }}</td>
                @endif
                @if($personajeSecreto->rarity != $resultado['atributos']->rarity)
                 <td class="incorrect">{{ $resultado['atributos']->rarity }}</td>
                @else
                    <td class="correct">{{ $resultado['atributos']->rarity }}</td>
                @endif       
                @if($personajeSecreto->attribute != $resultado['atributos']->attribute)
                    <td class="incorrect">{{ $resultado['atributos']->attribute }}</td>
                @else
                    <td class="correct">{{ $resultado['atributos']->attribute }}</td>
                @endif      
               @if($personajeSecreto->noblePhantasmCard != $resultado['atributos']->noblePhantasmCard)
                    <td class="incorrect">{{ $resultado['atributos']->noblePhantasmCard }}</td>
                @else
                 <td class="correct">{{ $resultado['atributos']->noblePhantasmCard }}</td>
                @endif
                @if($personajeSecreto->noblePhantasmEffect != $resultado['atributos']->noblePhantasmEffect)
                    <td class="incorrect">{{ $resultado['atributos']->noblePhantasmEffect }}</td>
                @else
                    <td class="correct">{{ $resultado['atributos']->noblePhantasmEffect }}</td>
                @endif
            </tr>
            @endforeach
        </tbody>
    </table>

    @if($acertado)
    <script>
        window.onload = function() {
            const cajaResultado = document.getElementById('cajaResultado');
            if (cajaResultado) {
                cajaResultado.scrollIntoView({ behavior: 'smooth' });
            }
        }
    </script>
    <div id="cajaResultado">
<div class="caja" id="caja">
    <div class="cajaDentro">
        <div class="textoCaja">
            <div>
                <h2>NICE!</h2>
                <h2>YOU GUESSED<br>{{ $personajeSecreto->name }}</h2>
                <p>NUMBER OF TRIES: {{ session('numeroIntentosIlimitado') }}</p>
            </div>
            <form action="{{ route('reiniciarIlimitado') }}" method="GET">
                <button type="submit" class="search-button">Play again</button>
            </form>
            
            
        </div>
        <div>
            <img src="{{ $personajeSecreto->img }}" class="result-img">
        </div>
    </div>
</div>
</div>
@endif

@if($rendido && !$acertado)
    <script>
        window.onload = function() {
            const cajaResultado = document.getElementById('cajaResultado');
            if (cajaResultado) {
                cajaResultado.scrollIntoView({ behavior: 'smooth' });
            }
        }
    </script>
    <div id="cajaResultado">
<div class="caja" id="caja">
    <div class="cajaDentro">
        <div class="textoCaja">
            <div>
                <h2>Ooops!</h2>
                <h2>THAT WAS A DIFFICULT ONE<br></h2>
                <p>The Servant was {{ $personajeSecreto->name }}</p>
            </div>
            <form action="{{ route('reiniciarIlimitado') }}" method="GET">
                <button type="submit" class="search-button">Play again</button>
            </form>
            
            
        </div>
        <div>
            <img src="{{ $personajeSecreto->img }}" class="result-img">
        </div>
    </div>
</div>
</div>
@endif


<script>
    //cortesia de https://stackoverflow.com/questions/54256629/countdown-to-midnight-refresh-every-day    
    var div=document.getElementById("cuentaAtras");
 
 setInterval(function(){ 
   var toDate=new Date();
   var tomorrow=new Date();
   tomorrow.setUTCHours(24,0,0,0);
   var diffMS=tomorrow.getTime()/1000-toDate.getTime()/1000;
   var diffHr=Math.floor(diffMS/3600);
   diffMS=diffMS-diffHr*3600;
   var diffMi=Math.floor(diffMS/60);
   diffMS=diffMS-diffMi*60;
   var diffS=Math.floor(diffMS);
   var result=((diffHr<10)?"0"+diffHr:diffHr);
   result+=":"+((diffMi<10)?"0"+diffMi:diffMi);
   result+=":"+((diffS<10)?"0"+diffS:diffS);
   div.innerHTML=result;
   
 },1000);
</script>

    <script>
        const input = document.querySelector('.search-input');
        const suggestions = document.getElementById('suggestions');
    
        input.addEventListener('input', function () {
            const query = this.value.trim();
    
            if (query.length === 0) {
                suggestions.innerHTML = '';
                return;
            }
    
            fetch(`/autocompletar?query=${encodeURIComponent(query)}`)
                .then(response => response.json())
                .then(data => {
                    suggestions.innerHTML = '';
    
                    data.forEach(name => {
                        const div = document.createElement('div');
                        div.textContent = name;
                        div.style.padding = '5px';
                        div.style.cursor = 'pointer';
                        div.style.backgroundColor = '#fff';
                        div.style.border = '1px solid #ccc';
                        div.style.borderTop = 'none';
    
                        div.addEventListener('click', () => {
                            input.value = name;
                            suggestions.innerHTML = '';
                        });
    
                        suggestions.appendChild(div);
                    });
                });
        });
    
        document.addEventListener('click', function (e) {
            if (!input.contains(e.target) && !suggestions.contains(e.target)) {
                suggestions.innerHTML = '';
            }
        });
    </script>
    
    
</body>
</html>