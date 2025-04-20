<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Servant;
use App\Models\Stats;
use App\Models\ServantSecreto;
use Illuminate\Support\Facades\Auth;




class GameController extends Controller
{
    public function showGame()
    {
         // session()->forget('resultados'); // Borra intentos
        // session()->forget('error'); // Borra intentos

        $stats = null;
        if (Auth::check()) {
            $user = Auth::user();
            $stats = Stats::where('idUser', $user->id)->first();
        }

        $personajeSecreto = $this->asignarPersonajeSecreto();
        return view('game', ['stats' => $stats], ['personajeSecreto' => $personajeSecreto]);
    }

    public function showHome()
    {
        return view('home');
    }



   /* public function personajeSecreto()
    {
        $fechaActual = date('Y-m-d');

        if (!session()->has("personajeSecreto_$fechaActual")) {
            $personajeSecreto = Servant::inRandomOrder()->first();
            session(["personajeSecreto_$fechaActual" => $personajeSecreto->id]);
        } else {
            $personajeSecreto = Servant::find(session("personajeSecreto_$fechaActual"));
        }

        return $personajeSecreto;
    }
        */

        public function asignarPersonajeSecreto()
{
    $fechaActual = gmdate('Y-m-d');
    
    // Ver personaje de hoy
    $servantSecreto = ServantSecreto::where('fecha', $fechaActual)->first();

    if (!$servantSecreto) {
        // Si no hay personaje meter uno
        $personajeAleatorio = Servant::inRandomOrder()->first();
        $servantSecreto = new ServantSecreto();
        $servantSecreto->idServant = $personajeAleatorio->id;
        $servantSecreto->fecha = $fechaActual;
        $servantSecreto->save();

        session()->forget('resultados'); // Borra intentos
        session()->forget('error'); // Borra intentos
        session()->forget('numeroIntentos'); // Borra intentos
    }


    $personajeSecreto = Servant::find($servantSecreto->idServant);
    
    return $personajeSecreto;
}


    public function comprobar(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string',
        ]);

        $personajeSecreto = $this->asignarPersonajeSecreto();


        $personajeUsuario = Servant::where('name', $request->nombre)->first();

        if (!$personajeUsuario) {
            return redirect()->route('juego')->with('error', 'There is not a Servant with that name.');
        }

        //intentos del usuario
        $resultados = session('resultados', []);
        $numeroIntentos = session('numeroIntentos', 0); 
        $rachaActual = session('rachaActual', 0); 
        $numeroIntentos++;
        session(['numeroIntentos' => $numeroIntentos]); 

        foreach ($resultados as $resultado) {
            if ($resultado['nombre'] === $personajeUsuario->name) {
                $numeroIntentos--;
                session(['numeroIntentos' => $numeroIntentos]);
                return redirect()->route('juego')->with('error', 'You already tried that one.');
            }
        }

        $acertado = false;

        if ($personajeSecreto->name == $personajeUsuario->name) {
            $acertado = true;

            array_unshift($resultados, [
                'nombre' => $personajeUsuario->name,
                'resultado' => 'Correcto',
                'atributos' => $personajeUsuario
            ]);

            $rachaActual++;
            session(['rachaActual' => $rachaActual]);

        } else {
            array_unshift($resultados, [
                'nombre' => $personajeUsuario->name,
                'resultado' => 'Incorrecto',
                'atributos' => $personajeUsuario
            ]);
        }

        if (auth()->check()) {
            $user = auth()->user();
            $userId = $user->id;
       
            // ver si el usuario ya tiene estadisticas
            $userStats = Stats::where('idUser', $userId)->first();
       
            if ($acertado) {
                // actualizar estadísticas si acierta
                if (!$userStats) {
                    $userStats = new Stats();
                    $userStats->idUser = $userId;
                    $userStats->currentStreak = 1;
                    $userStats->totalTries = $numeroIntentos;
                    $userStats->min_tries_servant = $personajeSecreto->id;
                    $userStats->min_tries_count = $numeroIntentos;
                    $userStats->total_guesses = 1;
                    $userStats->save();
                } else {
                    $userStats->currentStreak = $userStats->currentStreak + 1;
                    $userStats->totalTries = $userStats->totalTries + $numeroIntentos;
                    $userStats->total_guesses = $userStats->total_guesses + 1;
            
                    if ($userStats->min_tries_count === null || $numeroIntentos < $userStats->min_tries_count) {
                        $userStats->min_tries_servant = $personajeSecreto->id;
                        $userStats->min_tries_count = $numeroIntentos;
                    }
            
                    $userStats->save();
                }
            }
            
            
        }
       
        
        session(['resultados' => $resultados]);


        return redirect()->route('juego');
    }






    public function search(Request $request)
    {
        $query = $request->get('query');

        $servants = Servant::where('name', 'like', "%{$query}%")
            ->limit(10)
            ->pluck('name');

        return response()->json($servants);
    }
}
