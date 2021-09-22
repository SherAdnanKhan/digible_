<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use App\Mail\SendNotification;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Notifications\Users\ProductAvailiblityNotification;

class SendNotificationJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected $user;
    protected $data;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($user, $data)
    {
        $this->user = $user;
        $this->data = $data;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $this->user->notify(new ProductAvailiblityNotification($this->data));
    }
}
