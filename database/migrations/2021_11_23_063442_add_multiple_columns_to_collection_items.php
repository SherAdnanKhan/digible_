<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMultipleColumnsToCollectionItems extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('collection_items', function (Blueprint $table) {
            $table->timestamp('end_date')->nullable()->after('available_at');
            $table->timestamp('start_date')->nullable()->after('available_at');
            $table->unsignedTinyInteger('available_for_sale')->default(0)->comment('0:not for sale, 1: for sale, 2: auction')->after('price');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('collection_items', function (Blueprint $table) {
            $table->dropColumn('start_date');
            $table->dropColumn('end_date');
            $table->dropColumn('available_for_sale');
        });
    }
}
