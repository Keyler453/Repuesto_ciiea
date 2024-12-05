<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\DatabaseMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;

class NewActionNotification extends Notification
{
    use Queueable;

    private $user;

    public function __construct($user)
    {
        $this->user = $user;
    }

    public function via($notifiable)
    {
        return ['database']; // Aquí puedes agregar 'mail' si quieres enviar notificaciones por correo.
    }

    public function toDatabase($notifiable)
    {
        return new DatabaseMessage([
            'message' => $this->user->name . ' ha realizado una acción en el foro.',
            'action_url' => route('some.route'), // Puedes redirigir a la acción relacionada.
        ]);
    }
}
