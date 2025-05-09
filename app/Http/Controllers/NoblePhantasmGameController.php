<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Servant;
use App\Models\Stats;
use App\Models\ServantSecreto;
use Illuminate\Support\Facades\Auth;
use DateTime;




class NoblePhantasmGameController extends Controller
{
    public function showGame()
{
    $stats = null;
    if (Auth::check()) {
        $user = Auth::user();
        $stats = Stats::where('idUser', $user->id)->first();
    }

    $videoPath = public_path('videos');
    $videos = glob($videoPath . '/*.mp4');
 
    if (empty($videos)) {
        abort(404, 'Tere is no videos');
    }

    
    $fechaInicio = new DateTime('2025-05-05');
    $today = new DateTime(); //'+1 day'

    $diasTranscurridos = $fechaInicio->diff($today)->days;

    $index = $diasTranscurridos % count($videos);
    $videoSeleccionado = $videos[$index];

    $videoFinal = basename($videoSeleccionado); //coger solo el nombre del archivo
    $respuesta = pathinfo($videoSeleccionado, PATHINFO_FILENAME);
    $respuesta = strtolower(preg_replace('/^np_/', '', $respuesta));


    return view('videoNpGame', [
        'stats' => $stats,
        'video' => $videoFinal,
        'respuesta' => $respuesta,
    ]);
}



    public function showHome()
    {
        return view('home');
    }





    public function asignarPersonajeSecretoVideoNp()
{

    $personajeSecreto =  "lol";
    
    return $personajeSecreto;

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
