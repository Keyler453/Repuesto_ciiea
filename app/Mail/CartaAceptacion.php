<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CartaAceptacion extends Mailable
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
        return $this->subject('Carta de Aceptación')
                    ->view('emails.carta_aceptacion')
                    ->with('data', $this->data);
    }
}
