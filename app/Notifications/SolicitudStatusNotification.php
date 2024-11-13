<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class SolicitudStatusNotification extends Notification
{
    use Queueable;

    protected $solicitud;
    protected $status;

    public function __construct($solicitud, $status)
    {
        $this->solicitud = $solicitud;
        $this->status = $status;
    }

    public function via($notifiable)
    {
        // You can add 'database', 'broadcast' if you want to notify via more channels
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        $statusMessage = $this->status == 'aprobado'
            ? '¡Felicidades! Tu solicitud ha sido aprobada.'
            : 'Lo sentimos, tu solicitud ha sido rechazada.';

        return (new MailMessage)
            ->subject('Estado de tu solicitud')
            ->greeting('Hola ' . $notifiable->name . ',')
            ->line($statusMessage)
            ->line('Detalles de la solicitud:')
            ->line('Auditorio: ' . $this->solicitud->auditorio->nombre)
            ->line('Fecha de Uso: ' . $this->solicitud->fecha_uso)
            ->line('Hora de Inicio: ' . $this->solicitud->hora_inicio)
            ->line('Hora de Fin: ' . $this->solicitud->hora_final)
            ->line('Actividad: ' . $this->solicitud->actividad)
            ->action('Ver más detalles', url('/solicitudes'))
            ->line('Gracias por usar nuestro sistema!');
    }
}
