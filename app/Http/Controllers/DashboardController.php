<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Stats;
use App\Models\Servant;
use Illuminate\Support\Facades\Auth;


class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $stats = Stats::where('idUser', $user->id)->first(); 

        $minServant = null;

        if ($stats && $stats->min_tries_servant) {
            $minServant = Servant::find($stats->min_tries_servant);
        }


        //return view('dashboard')->with('stats', $stats, 'minServant', $minServant);
        return view('dashboard', ['stats' => $stats], ['minServant' => $minServant]);

    }
}
