<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Servant;
use App\Models\ServantSecreto;




class GameController extends Controller
{
    public function showGame()
    {
         // session()->forget('resultados'); // Borra intentos
        // session()->forget('error'); // Borra intentos
        $personajeSecreto = $this->asignarPersonajeSecreto();
        return view('game')->with('personajeSecreto', $personajeSecreto);
    }



   /* public function personajeSecreto()
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
        */

        public function asignarPersonajeSecreto()
{
    $fechaActual = gmdate('Y-m-d');
    
    // Ver si ya hay un personaje para hoy
    $servantSecreto = ServantSecreto::where('fecha', $fechaActual)->first();

    if (!$servantSecreto) {
        // Si la base de datos esta vacia mete al primer servatnt
        $personajeAleatorio = Servant::inRandomOrder()->first();
        $servantSecreto = new ServantSecreto();
        $servantSecreto->idServant = $personajeAleatorio->id;
        $servantSecreto->fecha = $fechaActual;
        $servantSecreto->save();
    }

    // No se actualiza el personaje si ya existe uno para el día

    $personajeSecreto = Servant::find($servantSecreto->idServant);
    
    // Devolver la respuesta
    return $personajeSecreto;
}

        

public function mostrarPersonajeSecreto()
{
    $fechaActual = date('Y-m-d');
    
    // Obtener el personaje secreto del día
    $servantSecreto = ServantSecreto::where('fecha', $fechaActual)->first();

    if (!$servantSecreto) {
        // Si no existe, asignar un personaje aleatorio y guardarlo
        $personajeAleatorio = Servant::inRandomOrder()->first();
        
        $servantSecreto = new ServantSecreto();
        $servantSecreto->personaje_id = $personajeAleatorio->id;
        $servantSecreto->fecha = $fechaActual;
        $servantSecreto->save();
    }

    // Pasamos el personaje secreto a la vista
    return view('personajeSecreto', ['personajeSecreto' => $servantSecreto]);
}



    public function comprobar(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string',
        ]);

        $personajeSecreto = $this->asignarPersonajeSecreto();


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

    public function search(Request $request)
    {
        $query = $request->get('query');

        $servants = Servant::where('name', 'like', "%{$query}%")
            ->limit(10)
            ->pluck('name');

        return response()->json($servants);
    }
}
