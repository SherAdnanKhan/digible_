<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeStatusFromAuctions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('auctions', function (Blueprint $table) {
            $table->dropColumn('status');
        });

        Schema::table('auctions', function (Blueprint $table) {
            $table->enum('status', ['pending', 'won', 'lost', 'purchased', 'expired'])->default('pending')->after('last_price');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('auctions', function (Blueprint $table) {
            $table->dropColumn('status');
        });

        Schema::table('auctions', function (Blueprint $table) {
            $table->enum('status', ['pending', 'success', 'failed', 'expired'])->default('pending')->after('last_price');
        });
    }
}
