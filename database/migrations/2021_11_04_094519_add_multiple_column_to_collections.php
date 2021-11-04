<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMultipleColumnToCollections extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('collections', function (Blueprint $table) {
            $table->string('telegram')->nullable()->after("status");
            $table->string('medium')->nullable()->after("status");
            $table->string('instagram')->nullable()->after("status");
            $table->string('twitter')->nullable()->after("status");
            $table->string('discord')->nullable()->after("status");
            $table->string('website')->nullable()->after("status");
            $table->string('categories')->nullable()->after("status");
            $table->string('description')->nullable()->after("status");
            $table->string('external_url')->nullable()->after("status");
            $table->string('banner_image')->nullable()->after("status");
            $table->string('featured_image')->nullable()->after("status");
            $table->string('logo_image')->nullable()->after("status");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('collections', function (Blueprint $table) {
            $table->dropColumn('telegram');
            $table->dropColumn('medium');
            $table->dropColumn('instagram');
            $table->dropColumn('twitter');
            $table->dropColumn('discord');
            $table->dropColumn('website');
            $table->dropColumn('categories');
            $table->dropColumn('description');
            $table->dropColumn('external_url');
            $table->dropColumn('banner_image');
            $table->dropColumn('featured_image');
            $table->dropColumn('logo_image');
            
        });
    }
}
