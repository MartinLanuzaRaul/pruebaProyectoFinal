<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\Servant;


class ApiDataController extends Controller
{
    public function importServants()
    {
        $classes = ['saber', 'archer', 'lancer', 'rider', 'caster', 'assassin', 'berserker', 'shielder', 'ruler', 'alterEgo', 'avenger', 'moonCancer', 'foreigner', 'pretender', 'beast'];
        
        foreach ($classes as $class) {
            $response = Http::get("https://api.atlasacademy.io/nice/NA/servant/search?lore=false&excludeCollectionNo=0&className={$class}");
            
            if ($response->successful()) {
                $data = $response->json();
    
                if (isset($data[0])) {
                    foreach ($data as $servant) {
                        $img = $servant['extraAssets']['charaGraph']['ascension']['4'] ?? null;
                        $faceImg = $servant['extraAssets']['faces']['ascension']['4'] ?? null;

    
                        if ($img == null) {
                            $img = $servant['extraAssets']['charaGraph']['ascension']['0'] ?? null;
                        } 

                        if ($faceImg == null) {
                            $faceImg = $servant['extraAssets']['charaGraph']['ascension']['0'] ?? null;
                        } 

                        Servant::create([
                            'servantId' => $servant['id'],
                            'name' => $servant['name'],
                            'gender' => $servant['gender'],
                            'className' => $servant['className'],
                            'rarity' => $servant['rarity'],
                            'attribute' => $servant['attribute'],
                            'atkBase' => $servant['atkBase'],
                            'hpBase' => $servant['hpBase'],
                            'img' => $img,
                            'faceImg' => $faceImg,
                            'noblePhantasmCard' => $servant['noblePhantasms'][0]['card'] ?? null,
                            'noblePhantasmEffect' => $servant['noblePhantasms'][0]['effectFlags'][0] ?? null
                        ]);
                    }
                } else {
                    return response()->json('Error: No se encontraron datos de servants');
                }
            } else {
                return response()->json('Error: No se pudo obtener datos de la API');
            }
        }
    
        return response()->json('Datos insertados exitosamente');
    }
}