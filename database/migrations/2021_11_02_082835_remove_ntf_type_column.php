<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemoveNtfTypeColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('collection_items', function (Blueprint $table) {
            $table->dropColumn('nft_type');
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
            $table->enum('nft_type', ['backed', 'nonbacked', 'nonnft'])->default('nonnft');
        });
    }
}
