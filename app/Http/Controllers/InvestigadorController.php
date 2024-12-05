<?php

namespace App\Http\Controllers;

use App\Models\Record;
use Illuminate\Http\Request;

class InvestigadorController extends Controller
{
    public function getInvestigadores()
    {
        // Recupera solo el nombre y el email de la tabla 'records'
        $investigadores = Record::select('nombre', 'email')->get();

        // Devuelve la respuesta en formato JSON
        return response()->json($investigadores);
    }
}

