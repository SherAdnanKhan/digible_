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
    protected $user;

    public function __construct($data, $user)
    {
        $this->data = $data;
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
        $productLink = config('app.client_url') . "/collections/" . $this->data->collection['id'] . "/collection-items/" . $this->data['id'];
        $user_date = Carbon::createFromFormat('Y-m-d H:i:s', $this->data["available_at"], 'UTC');
        $timezone = User::where('id', $this->data['user_id'])->select("timezone")->first();
        $user_date->setTimezone($timezone);
        return (new MailMessage)
            ->subject('Product is Availible')
            ->markdown('email_template.product.available_email', ['product' => $this->data, 'date' => $user_date, 'productLink' => $productLink, 'user' => $this->user]);
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
