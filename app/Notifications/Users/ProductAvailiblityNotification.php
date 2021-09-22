<?php

namespace App\Notifications\Users;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ProductAvailiblityNotification extends Notification
{
    use Queueable;

    protected $data;

    public function __construct($data) {
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
        $productLink = config('app.client_url')."/collections/".$this->data['collection_id']."/collection-items/".$this->data['id'];
        return (new MailMessage)
            ->subject('Product is Availible')
            ->line('The Item'.$this->data["name"].' you have been waiting for is available now.')
            ->action('Product Link', $productLink)
            ->line('This product is also be available to other customers , so its possible that it is sold quickly!');
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
