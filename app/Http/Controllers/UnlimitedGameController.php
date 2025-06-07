<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Servant;
use App\Models\Stats;
use App\Models\ServantSecreto;
use Illuminate\Support\Facades\Auth;




class UnlimitedGameController extends Controller
{
    public function showGame()
{
    $stats = null;
    if (Auth::check()) {
        $user = Auth::user();
        $stats = Stats::where('idUser', $user->id)->first();
    }

    if (!session()->has('personajeSecretoIlimitado')) {
        $personajeSecreto = $this->asignarPersonajeSecretoIlimitado();
        session(['personajeSecretoIlimitado' => $personajeSecreto]);
    } else {
        $personajeSecreto = session('personajeSecretoIlimitado');
    }

    $rendido = session('rendido', false); 
    session()->forget('rendido'); 

    return view('unlimitedGame', [
        'stats' => $stats,
        'personajeSecreto' => $personajeSecreto,
        'rendido' => $rendido,
    ]);
}



    public function showHome()
    {
        return view('home');
    }





        public function asignarPersonajeSecretoIlimitado()
{

    $personajeSecreto =  Servant::inRandomOrder()->first();
    
    return $personajeSecreto;

}


    public function comprobarIlimitado(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string',
        ]);

        $personajeSecreto = session('personajeSecretoIlimitado');


        $personajeUsuario = Servant::where('name', $request->nombre)->first();

        if (!$personajeUsuario) {
            return redirect()->route('juegoIlimitado')->with('error', 'There is not a Servant with that name.');
        }

        //intentos del usuario
        $resultadosIlimitado = session('resultadosIlimitado', []);
        $numeroIntentosIlimitado = session('numeroIntentosIlimitado', 0); 
        $numeroIntentosIlimitado++;
        session(['numeroIntentosIlimitado' => $numeroIntentosIlimitado]); 

        foreach ($resultadosIlimitado as $resultado) {
            if ($resultado['nombre'] === $personajeUsuario->name) {
                $numeroIntentosIlimitado--;
                session(['numeroIntentosIlimitado' => $numeroIntentosIlimitado]);
                return redirect()->route('juegoIlimitado')->with('error', 'You already tried that one.');
            }
        }

        $acertado = false;

        if ($personajeSecreto->name == $personajeUsuario->name) {
            $acertado = true;

            

            array_unshift($resultadosIlimitado, [
                'nombre' => $personajeUsuario->name,
                'resultado' => 'Correcto',
                'atributos' => $personajeUsuario
            ]);

            

        } else {
            array_unshift($resultadosIlimitado, [
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
                    $userStats->numeroIntentosIlimitado = $numeroIntentosIlimitado; 
                    $userStats->Unlimited_total_guesses = 1;  
                    $userStats->min_tries_servant_ilimitado = $personajeSecreto->id;
                    $userStats->min_tries_count_ilimitado = $numeroIntentosIlimitado;
                    $userStats->save();
                } else {
                    $userStats->numeroIntentosIlimitado = $userStats->numeroIntentosIlimitado + $numeroIntentosIlimitado;
                    $userStats->Unlimited_total_guesses = $userStats->Unlimited_total_guesses + 1;

                    if ($userStats->min_tries_count_ilimitado === null || $numeroIntentosIlimitado < $userStats->min_tries_count_ilimitado) {
                        $userStats->min_tries_servant_ilimitado = $personajeSecreto->id;
                        $userStats->min_tries_count_ilimitado = $numeroIntentosIlimitado;
                    }
            
                    $userStats->save();
                }
            }
            
            
        }
       
        
        session(['resultadosIlimitado' => $resultadosIlimitado]);


        return redirect()->route('juegoIlimitado');
    }

    public function reiniciarJuego()
{
    
    $personajeSecreto = $this->asignarPersonajeSecretoIlimitado();
    session(['personajeSecretoIlimitado' => $personajeSecreto]);

    
    session()->forget('resultadosIlimitado');
    session()->forget('numeroIntentosIlimitado');

    return redirect()->route('juegoIlimitado');
}


public function rendirse()
{
    session(['rendido' => true]);
    return redirect()->route('juegoIlimitado');
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
