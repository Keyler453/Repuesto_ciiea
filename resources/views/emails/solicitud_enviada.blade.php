@component('mail::message')
# Nueva solicitud enviada

Se ha enviado una nueva solicitud con los siguientes datos:

- **Nombre Completo:** {{ $data['nombreCompleto'] }}
- **Edad:** {{ $data['edad'] }}
- **Sexo:** {{ $data['sexo'] }}
- **Grado de Estudios:** {{ $data['gradoEstudios'] }}
- **Institución:** {{ $data['institucion'] }}
- **Departamento:** {{ $data['departamento'] }}
- **Dirección Institución:** {{ $data['direccionInstitucion'] }}
- **Ciudad:** {{ $data['ciudad'] }}
- **Estado:** {{ $data['estado'] }}
- **Tipo de Institución:** {{ $data['tipoInstitucion'] }}
- **Teléfono Oficina:** {{ $data['telefonoOficina'] }}
- **Celular:** {{ $data['celular'] }}
- **Email Institucional:** {{ $data['emailInstitucional'] }}
- **Email Personal:** {{ $data['emailPersonal'] }}
- **Línea de Investigación:** {{ $data['lineaInvestigacion'] }}
- **Nivel Educativo:** {{ $data['nivelEducativo'] }}

Gracias,<br>
{{ config('app.name') }}
@endcomponent
