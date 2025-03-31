<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Servant;



class GameController extends Controller
{
    public function showGame()
    {
         // session()->forget('resultados'); // Borra intentos
        // session()->forget('error'); // Borra intentos
        $personajeSecreto = $this->personajeSecreto();
        return view('game')->with('personajeSecreto', $personajeSecreto);
    }



    public function personajeSecreto()
    {
        $fechaActual = date('Y-m-d');

        // Verificamos si ya hay un personaje guardado para el día actual
        if (!session()->has("personajeSecreto_$fechaActual")) {
            $personajeSecreto = Servant::inRandomOrder()->first();
            session(["personajeSecreto_$fechaActual" => $personajeSecreto->id]);
        } else {
            $personajeSecreto = Servant::find(session("personajeSecreto_$fechaActual"));
        }

        return $personajeSecreto;
    }

    public function comprobar(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string',
        ]);

        $personajeSecreto = $this->personajeSecreto();


        $personajeUsuario = Servant::where('name', $request->nombre)->first();

        if (!$personajeUsuario) {
            return redirect()->route('juego')->with('error', 'El personaje no existe. Intenta de nuevo.');
        }

        //intentos del usuario
        $resultados = session('resultados', []);

        //evita duplicados de intento de personaje
        foreach ($resultados as $resultado) {
            if ($resultado['nombre'] === $personajeUsuario->name) {
                return redirect()->route('juego')->with('error', 'Este personaje ya ha sido probado.');
            }
        }


        if ($personajeSecreto->name == $personajeUsuario->name) {
            array_unshift($resultados, [
                'nombre' => $personajeUsuario->name,
                'resultado' => 'Correcto',
                'atributos' => $personajeUsuario
            ]);
        } else {
            array_unshift($resultados, [
                'nombre' => $personajeUsuario->name,
                'resultado' => 'Incorrecto',
                'atributos' => $personajeUsuario
            ]);
        }

        session(['resultados' => $resultados]);


        return redirect()->route('juego');
    }
}
