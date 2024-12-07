<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Record extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombreCompleto',
        'edad',
        'sexo',
        'gradoEstudios',
        'institucion',
        'departamento',
        'direccionInstitucion',
        'ciudad',
        'estado',
        'tipoInstitucion',
        'telefonoOficina',
        'celular',
        'emailInstitucional',
        'emailPersonal',
        'lineaInvestigacion',
        'nivelEducativo',
        'usuario',
        'correo',
        'contrasena',
    ];
}
