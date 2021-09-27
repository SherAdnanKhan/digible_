<?php

namespace App\Console\Commands;

use App\Models\CollectionItem;
use Carbon\Carbon;
use Illuminate\Console\Command;

class SendDailyEmails extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'jobs:digest';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send daily emails to users with availibilty of new collection items';

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
        $collectionItems = CollectionItem::with('collection.user')->where('available_at', '>=', Carbon::now())
            ->where('available_at', '<=', Carbon::now()->addDays(1))->get();
        foreach ($collectionItems as $collectionItem) {
            dispatch(new \App\Jobs\SendNotificationJob($collectionItem->collection->user, $collectionItem));
        }
    }
}
