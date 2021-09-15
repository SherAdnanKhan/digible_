<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModfiyPnoToPhonenumberTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('seller_profiles', function (Blueprint $table) {
            $table->renameColumn('p_no', 'phone_no');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('seller_profiles', function (Blueprint $table) {
            $table->renameColumn('phone_no' , 'p_no');
        });
    }
}
