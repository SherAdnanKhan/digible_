<?php

namespace App\Notifications\Auctions;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class WonBetNotification extends Notification
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
        $productLink = config('app.client_url') . "/collections/" . $this->data->collection_id . "/collection-items/" . $this->data->id;
        return (new MailMessage)
            ->subject('Bet won successfully')
            ->line('You have won the bet against item' . $this->data->name . ', you can purchased the product by clicking the purchase now below.')
            ->action('Purchase Now', $productLink);
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
