<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class MailResetPasswordNotification extends Notification
{
    use Queueable;
    public $token;
    public static $toMailCallback;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($token)
    {
        $this->token = $token;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail(object $notifiable): MailMessage
    {
        $url = "http://localhost:3000/reset/" . $this->token;

        if (static::$toMailCallback) {
            return call_user_func(static::$toMailCallback, $notifiable, $this->token);
        }

        return (new MailMessage)
                    ->subject('Solicitud para restablecer contraseña')
                    ->line('Hemos recibido una solicitud de restablecimiento de contraseña
                    para su cuenta. Para continuar proceda a hacer click en el siguient botón.')
                    ->action('Cambio de contraseña', $url)
                    ->line('Este enlace de restablecimiento de contraseña caducará en' . 
                    config('auth.passwords.users.expire') . 'minutos.')
                    ->line('Si no solicitó un restablecimiento de contraseña, no se requiere 
                    ninguna otra acción.');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}