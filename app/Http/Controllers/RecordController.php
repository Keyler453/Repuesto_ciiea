<?php

namespace App\Http\Controllers;

use App\Models\Record;
use Illuminate\Http\Request;

class RecordController extends Controller
{
    public function store(Request $request)
    {
        // Validar los datos del formulario
        $validated = $request->validate([
            'nombreCompleto' => 'required|string|max:255',
            'edad' => 'required|integer|min:0',
            'sexo' => 'required|string',
            'gradoEstudios' => 'required|string|max:255',
            'institucion' => 'required|string|max:255',
            'departamento' => 'required|string|max:255',
            'direccionInstitucion' => 'required|string|max:255',
            'ciudad' => 'required|string|max:255',
            'estado' => 'required|string|max:255',
            'tipoInstitucion' => 'required|string',
            'telefonoOficina' => 'required|string|max:20',
            'celular' => 'required|string|max:20',
            'emailInstitucional' => 'required|email|unique:records,emailInstitucional',
            'emailPersonal' => 'nullable|email',
            'lineaInvestigacion' => 'required|string|max:255',
            'nivelEducativo' => 'required|string|max:255',
            'usuario' => 'required|string|unique:records,usuario|max:255',
            'correo' => 'required|email|unique:records,correo',
            'contrasena' => 'required|string|min:8',
        ]);

        // Encriptar la contraseña antes de guardarla
        $validated['contrasena'] = bcrypt($validated['contrasena']);

        // Crear el registro
        Record::create($validated);

        // Redirigir a la misma página con un mensaje de éxito y limpiar los campos del formulario
        return redirect()->back()->with('message', 'Registro realizado con éxito.');
    }
}
