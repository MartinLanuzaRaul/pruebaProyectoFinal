<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fatedle - Guess NP</title>
    <link rel="preload" as="image" href="/images/background.png">

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

        .game-container {
            max-width: 900px;
            margin: 0 auto;
        }

        .video-container {
            position: relative;
            display: inline-block;
        }

        #npVideo {
            width: 100%;
            border-radius: 10px;
        }

        .blur {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    backdrop-filter: blur(30px); 
    background-color: rgba(255, 255, 255, 0.3); 
    transition: all 1s ease;
    border-radius: 10px;
    z-index: 10;
}


        button {
            padding: 10px 20px;
            font-size: 16px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-top: 20px;
        }

        button:hover {
            background-color: #0056b3;
        }

        .guess-prompt {
            margin-top: 20px;
        }

        input {
            padding: 10px;
            font-size: 16px;
            width: 60%;
            border-radius: 5px;
            margin-right: 10px;
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
        .tablaServants {
    border-collapse: separate;
    border-spacing: 10px; /
    margin: 0 auto; 
    table-layout: fixed;
    width: auto;
    margin-bottom: 5%;
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
#feedback{
    text-align: center;
}
    </style>
</head>
<body>
    
    <a href="{{route('login')}}"><button class="login">Account</button></a>
    <a href="{{route('home')}}"><div class="logo"><img id="logo" src="images/logo.png" height="350px" width="350px"></div></a>

    
                            

        
         
    

    <div class="caja" id="caja">
        <div class="cajaDentro">
            <div class="textoCaja">
                <div>
                    <h2>GUESS TODAY'S NOBLE PHANTASM</h2>
                    <p>type any character to begin</p>
                    <p id="feedback"></p>
                </div>
            </div>
            
        </div>
    </div>
    @if (session('error'))
    <div class="error-message"><br>
        {{ session('error') }}
    </div>
@endif
    <div class="game-container">
        

        <div class="video-container">
            <video id="npVideo" width="800" controls autoplay muted loop>
                <source src="videos/{{ $video }}" type="video/mp4">
                    Your browser does not support this video format.
            </video>
            <div id="blurEffect" class="blur"></div>
        </div>

        <div class="search-container">
            <input type="text" id="guessInput" class="search-input" placeholder="Type Servant name..." required autocomplete="off">
            <button id="submitGuessButton" class="search-button">Guess</button>
            <div id="suggestions" style="margin-top: 10px; text-align: left; width: 300px; position: absolute; background: white; z-index: 999;"></div>
        </div>

        

        
        <div style="display: flex; justify-content: center; width: 100%;">
        <table class="tablaServants">
            <thead>
                
            </thead>
            <tbody>
                @foreach (session('resultadosVideo', []) as $resultado)
                <tr>
                    <td>
                        <img src="{{ $resultado['atributos']->faceImg }}" alt="Imagen" style="max-width: 100px; height: auto; display: block; margin: auto;">
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    </div>
    <script>
        window.addEventListener('load', () => {
            const video = document.getElementById('npVideo');
            if (video) {
                video.scrollIntoView({ behavior: 'smooth', block: 'center' });
            }
        });
    </script>
    

    <script>
        let blurLevel = 30;
        const blurEffect = document.getElementById('blurEffect');
        const guessInput = document.getElementById('guessInput');
        const submitGuessButton = document.getElementById('submitGuessButton');
        const feedbackText = document.getElementById('feedback');
        

        submitGuessButton.addEventListener('click', () => {
            let guess = guessInput.value.trim().toLowerCase();
            guess = guess.replace(/[^a-z0-9]/g, '');
            console.log(guess);

            if (guess === "{{ strtolower($respuesta) }}") {
                feedbackText.textContent = "You got it!";
                feedbackText.style.color = "green";
                blurLevel = 0;
                blurEffect.style.backdropFilter = `blur(${blurLevel}px)`;
                guessInput.style.display = "none";
                submitGuessButton.style.display = "none";
            } else {
                feedbackText.textContent = "Incorrect. Try again.";
                feedbackText.style.color = "red";

                if (blurLevel > 0) {
                    blurLevel -= 5;
                    blurLevel = Math.max(0, blurLevel);
                    blurEffect.style.backdropFilter = `blur(${blurLevel}px)`;
                }
            }

            guessInput.value = '';
        });
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