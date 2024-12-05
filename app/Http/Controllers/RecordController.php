<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Record;
use Illuminate\Support\Facades\Mail;
use App\Mail\SolicitudEnviada;
use App\Mail\CartaAceptacion;

class RecordController extends Controller
{
    /**
     * Almacenar un nuevo registro en la base de datos.
     */
    public function store(Request $request)
    {
        // Validar los datos del formulario
        $validated = $request->validate([
            'nombreCompleto' => 'required|string|max:255',
            'edad' => 'required|integer',
            'sexo' => 'required|in:masculino,femenino,otro',
            'gradoEstudios' => 'required|string|max:255',
            'institucion' => 'required|string|max:255',
            'departamento' => 'required|string|max:255',
            'direccionInstitucion' => 'required|string|max:255',
            'ciudad' => 'required|string|max:255',
            'estado' => 'required|string|max:255',
            'tipoInstitucion' => 'required|in:publica,privada',
            'telefonoOficina' => 'required|string|max:20',
            'celular' => 'required|string|max:20',
            'emailInstitucional' => 'required|email',
            'emailPersonal' => 'required|email',
            'lineaInvestigacion' => 'required|string|max:255',
            'nivelEducativo' => 'required|string|max:255',
        ]);

        // Enviar correo al administrador con los datos del formulario
        Mail::to('caleth45yt@gmail.com')->send(new SolicitudEnviada($validated));

        // Crear un nuevo registro con los datos validados
        Record::create($validated);

        // Enviar la carta de aceptación al correo personal del usuario
        Mail::to($validated['emailPersonal'])->send(new CartaAceptacion($validated));

        // Retornar respuesta o redirección
        return response()->json(['message' => 'Formulario enviado y registrado con éxito.'], 200);
    }

    /**
     * Actualizar un registro específico en la base de datos.
     */
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'nombreCompleto' => 'required|string|max:255',
            'edad' => 'required|integer',
            'sexo' => 'required|in:masculino,femenino,otro',
            'gradoEstudios' => 'required|string|max:255',
            'institucion' => 'required|string|max:255',
            'departamento' => 'required|string|max:255',
            'direccionInstitucion' => 'required|string|max:255',
            'ciudad' => 'required|string|max:255',
            'estado' => 'required|string|max:255',
            'tipoInstitucion' => 'required|in:publica,privada',
            'telefonoOficina' => 'required|string|max:20',
            'celular' => 'required|string|max:20',
            'emailInstitucional' => 'required|email',
            'emailPersonal' => 'required|email',
            'lineaInvestigacion' => 'required|string|max:255',
            'nivelEducativo' => 'required|string|max:255',
        ]);

        $record = Record::findOrFail($id);
        $record->update($validated);

        return redirect()->route('records.index')->with('message', 'Registro actualizado con éxito.');
    }

    /**
     * Eliminar un registro específico de la base de datos.
     */
    public function destroy($id)
    {
        $record = Record::findOrFail($id);
        $record->delete();

        return redirect()->route('records.index')->with('message', 'Registro eliminado con éxito.');
    }
}
