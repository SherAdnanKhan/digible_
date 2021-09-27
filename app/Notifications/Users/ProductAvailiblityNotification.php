<?php

namespace App\Notifications\Users;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ProductAvailiblityNotification extends Notification
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
        $productLink = config('app.client_url') . "/collections/" . $this->data->collection['id'] . "/collection-items/" . $this->data['id'];
        $user_date = Carbon::createFromFormat('Y-m-d H:i:s', $this->data["available_at"], 'UTC');
        $timezone = User::where('id', $this->data['user_id'])->select("timezone")->first();
        $user_date->setTimezone($timezone);
        return (new MailMessage)
            ->subject('Product is Availible')
            ->line('The Item' . $this->data["name"] . ' you have been waiting for is available on ' . $user_date . '.')
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
