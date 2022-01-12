<?php

namespace App\Notifications\Sellers;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class SellerStatusNotification extends Notification
{
    use Queueable;

    protected $data;

    public function __construct($data)
    {
        $this->data = $data;
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
        return (new MailMessage)
            ->subject('Seller Request is ' . $this->data['status'])
            ->line('Your request for become seller has been ' . $this->data['status'])
            ->line($this->data['status'] == 'approved' ? "You can now sell on our platform!" : "Please provide all details correctly.");
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
