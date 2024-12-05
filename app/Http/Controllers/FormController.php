<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Record; 

class FormController extends Controller
{
    public function show()
    {
        // Renderiza la vista usando Inertia
        return inertia('Form/FormReime');
    }


 // App\Http\Controllers\FormController.php

public function store(Request $request)
{
    // Validar los datos enviados
    $validated = $request->validate([
        'nombreCompleto' => 'required|string|max:255',
        'edad' => 'required|integer|min:0',
        'sexo' => 'required|string|in:masculino,femenino,otro',
        'gradoEstudios' => 'nullable|string|max:255',
        'institucion' => 'nullable|string|max:255',
        'departamento' => 'nullable|string|max:255',
        'direccionInstitucion' => 'nullable|string|max:255',
        'ciudad' => 'nullable|string|max:255',
        'estado' => 'nullable|string|max:255',
        'tipoInstitucion' => 'required|string|in:publica,privada',
        'telefonoOficina' => 'nullable|string|max:20',
        'celular' => 'nullable|string|max:20',
        'emailInstitucional' => 'nullable|email|max:255',
        'emailPersonal' => 'nullable|email|max:255',
        'lineaInvestigacion' => 'nullable|string|max:255',
        'nivelEducativo' => 'nullable|string|max:255',
        'usuario' => 'required|string|max:255',
        'correo' => 'required|email|max:255',
        'contrasena' => 'required|string|min:8',
    ]);

    // Crear un nuevo registro
    Record::create([
        'nombreCompleto' => $validated['nombreCompleto'],
        'edad' => $validated['edad'],
        'sexo' => $validated['sexo'],
        'gradoEstudios' => $validated['gradoEstudios'],
        'institucion' => $validated['institucion'],
        'departamento' => $validated['departamento'],
        'direccionInstitucion' => $validated['direccionInstitucion'],
        'ciudad' => $validated['ciudad'],
        'estado' => $validated['estado'],
        'tipoInstitucion' => $validated['tipoInstitucion'],
        'telefonoOficina' => $validated['telefonoOficina'],
        'celular' => $validated['celular'],
        'emailInstitucional' => $validated['emailInstitucional'],
        'emailPersonal' => $validated['emailPersonal'],
        'lineaInvestigacion' => $validated['lineaInvestigacion'],
        'nivelEducativo' => $validated['nivelEducativo'],
        'usuario' => $validated['usuario'],
        'correo' => $validated['correo'],
        'contrasena' => bcrypt($validated['contrasena']), // Encriptar la contraseña
    ]);

    // Devolver una respuesta (redirección o éxito)
    return redirect()->back()->with('success', 'Formulario registrado con éxito.');
}


}

