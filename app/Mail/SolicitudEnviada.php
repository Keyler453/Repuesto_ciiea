<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SolicitudEnviada extends Mailable
{
    use Queueable, SerializesModels;

    public $data;

    /**
     * Crear una nueva instancia de mensaje.
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Construir el mensaje.
     */
    public function build()
    {
        return $this->subject('Nueva Solicitud de Registro')
                    ->markdown('emails.solicitud_enviada');
    }
}
