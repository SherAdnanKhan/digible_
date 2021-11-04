<?php

namespace App\Notifications\Users;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class PasswordResetNotification extends Notification
{
    use Queueable;

    protected $token;
    protected $user;

    public function __construct(string $token, User $user)
    {
        $this->token = $token;
        $this->user = $user;
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
        $passwordResetUrl = config('app.client_url') . '/auth/forget-password/' . $this->token;

        return (new MailMessage)
            ->subject('Reset Password')
            ->markdown('email_template.user.reset_email', ['user' => $this->user, 'passwordResetUrl' => $passwordResetUrl]);
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
