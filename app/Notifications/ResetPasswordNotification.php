<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ResetPasswordNotification extends Notification
{

    use Queueable;
    public $token;
    /**
     * Create a new notification instance.
     */
    public function __construct($token)
    {
        $this->token = $token;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail($notifiable)
    {
        $url = env('FRONTEND_URL', 'https://synel-coffe.vercel.app')
            . '/reset-password?token='
            . $this->token
            . '&email='
            . urlencode($notifiable->email);

    return (new MailMessage)

        ->subject('Reset Your Synel Coffee Password ☕')

        ->greeting('Hello Coffee Lover ☕')

        ->line('We received a password reset request for your Synel Coffee account.')

        ->action('Reset Password', $url)

        ->line('This reset link will expire in 60 minutes.')

        ->line('If you did not request this, no further action is required.')

        ->salutation('～ Synel Coffee');
}

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
