<?php

namespace App\Notifications\Users;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ProductFavouriteNotification extends Notification
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
        $productLink = config('app.client_url') . "/collection-items/" ;
        $user_date= '';
        if(isset($this->data["available_at"])){
        $user_date = Carbon::createFromFormat('Y-m-d H:i:s', $this->data["available_at"], 'UTC');
        $timezone = User::where('id', $this->user->id)->select("timezone")->first();
        $user_date->setTimezone($timezone);
        }

        return (new MailMessage)
            ->subject('Product is Favourited')
            ->markdown('email_template.product.favourite_email', ['product' => $this->data, 'date' => $user_date, 'productLink' => $productLink, 'user' => $this->user]);
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
