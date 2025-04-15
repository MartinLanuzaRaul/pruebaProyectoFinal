<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Fatedle</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Estilos personalizados -->
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            height: 100vh;
            background: url('/images/background.png') no-repeat center center fixed;
            background-size: cover;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: white;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            text-align: center;
        }

        .logo {
            margin-bottom: 0.5rem;
        }

        .subtitle {
            font-size: 1rem;
            font-weight: bold;
            margin-bottom: 2rem;
            color: black;

        }

        .button {
            background-color: #141414;
            color: white;
            padding: 1rem 2rem;
            margin: 0.5rem 0;
            border: none;
            cursor: pointer;
            font-size: 1.2rem;
            width: 200px;
            transition: background-color 0.3s;
        }

        .button:hover {
            background-color: #333;
        }

        .button.disabled {
            background-color: grey;
            cursor: not-allowed;
            position: relative;
        }

        .button.disabled span {
            position: absolute;
            font-size: 0.8rem;
            bottom: -1.5rem;
            left: 50%;
            transform: translateX(-50%);
            color: yellow;
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
        #logo {
            width: 600px;
            height: auto;
            
        }

    </style>
</head>
<body>
    <a href="{{route('login')}}"><button class="login">Account</button></a>

    <div class="logo"><img id="logo" src="images/logo.png"></div>
    <div class="subtitle">GUESS FATE/GRAND ORDER CHARACTERS</div>

    <a href="{{route('juego')}}"><button class="button">Classic</button></a>
    <a href="{{route('juego')}}"><button class="button">Wordle</button></a>
    
</body>
</html>
