<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Auction;
use App\Models\CollectionItem;
use Illuminate\Console\Command;
use SebastianBergmann\Environment\Console;

class SendWonEmails extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'jobs:send_won_bet_emails';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send daily emails to users who won bets every last 5 minutes.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $last_bets = Auction::where(["status" => Auction::STATUS_PENDING, ['created_at', '>=', Carbon::now()->addMinutes(-5)], ['created_at', '<', Carbon::now()]])->get();
        foreach ($last_bets as $last_bet) {
            $collectionItem = CollectionItem::where(['id' => $last_bet->collection_item_id, ["end_date", '<=', Carbon::now()]])->first();
            file_put_contents("/var/www/html/laravel-api/test.txt", print_r($collectionItem, true));
            if ($collectionItem) {
                $user = User::find($last_bet->buyer_id);
                dispatch(new \App\Jobs\WonBetJob($user, $collectionItem));
            }
        }
    }
}
