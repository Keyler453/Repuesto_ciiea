<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRecordsTable extends Migration
{
    public function up(): void
    {
        Schema::create('records', function (Blueprint $table) {
            $table->id();
            $table->string('nombreCompleto');
            $table->integer('edad');
            $table->string('sexo');
            $table->string('gradoEstudios');
            $table->string('institucion');
            $table->string('departamento');
            $table->string('direccionInstitucion');
            $table->string('ciudad');
            $table->string('estado');
            $table->string('tipoInstitucion');
            $table->string('telefonoOficina');
            $table->string('celular');
            $table->string('emailInstitucional')->unique();
            $table->string('emailPersonal')->nullable();
            $table->string('lineaInvestigacion');
            $table->string('nivelEducativo');
            $table->string('usuario')->unique();
            $table->string('correo')->unique();
            $table->string('contrasena');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('records');
    }
}

