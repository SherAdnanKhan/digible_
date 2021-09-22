<?php

namespace App\Notifications\Users;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PasswordResetNotification extends Notification
{
    use Queueable;

    protected $token;

    public function __construct(string $token) {
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
     * @param mixed $notifiable
     * @return MailMessage
     */
    public function toMail($notifiable)
    {
        $passwordResetUrl = config('app.client_url').'/auth/forget-password/'.$this->token;

        return (new MailMessage)
            ->subject('Reset Password')
            ->line('We’re almost there! Please click the button below to reset your password.')
            ->action('Reset Password', $passwordResetUrl)
            ->line('Thank you for using our application!')
            ->view(
                'email_template.user.notification_email', ['passwordResetUrl' => $passwordResetUrl]
            );
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
