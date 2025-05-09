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
    </style>
</head>
<body>
    <div class="game-container">
        <h1>Adivina el Noble Phantasm ({{ $video }})</h1>

        <div class="video-container">
            <video id="npVideo" width="800" controls autoplay muted loop>
                <source src="videos/{{ $video }}" type="video/mp4">
                Tu navegador no soporta este formato de video.
            </video>
            <div id="blurEffect" class="blur"></div>
        </div>

        <div class="search-container">
            <input type="text" id="guessInput" class="search-input" placeholder="Type Servant name..." required autocomplete="off">
            <button id="submitGuessButton" class="search-button">Guess</button>
            <div id="suggestions" style="margin-top: 10px; text-align: left; width: 300px; position: absolute; background: white; z-index: 999;"></div>
        </div>

        <p id="feedback"></p>
    </div>

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
            } else {
                feedbackText.textContent = "Incorrect. Try again.";
                feedbackText.style.color = "red";

                if (blurLevel > 0) {
                    blurLevel -= 3;
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