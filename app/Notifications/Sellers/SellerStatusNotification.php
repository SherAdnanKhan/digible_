<?php

namespace App\Notifications\Sellers;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

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
        $url = config('app.frontend') . '/login';
        $response = (new MailMessage)
            ->subject('Seller Request is ' . $this->data['status'])
            ->line('Your request for become seller has been ' . $this->data['status'])
            ->line($this->data['status'] == 'approved' ? "You can now sell on our platform, please click on login to sell!" : "Please provide all details correctly.");
        if ($this->data['status'] == 'approved') {
            $response->action('Login', $url);
        }
        return $response;
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
