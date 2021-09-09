<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCollectionItemsTable extends Migration {
 /**
  * Run the migrations.
  *
  * @return void
  */
 public function up() {
  Schema::create('collection_items', function (Blueprint $table) {
   $table->id();
   $table->foreignId('collection_item_type_id')->references('id')->on('collection_item_types')->onDelete('cascade')->onUpdate('cascade');
   $table->foreignId('collection_id')->references('id')->on('collections')->onDelete('cascade')->onUpdate('cascade');
   $table->boolean('physical')->default(false)->nullable();
   $table->string('name')->nullable();
   $table->string('image')->nullable();
   $table->string('description')->nullable();
   $table->string('edition')->nullable();
   $table->string('graded')->nullable();
   $table->timestamp('year')->nullable();
   $table->integer('population')->nullable();
   $table->string('publisher')->nullable();
   $table->enum('status', ['Pending', 'Approved', 'Rejected'])->default('Pending')->nullable();
   $table->timestamps();
  });
 }

 /**
  * Reverse the migrations.
  *
  * @return void
  */
 public function down() {
  Schema::dropIfExists('collection_items');
 }
}
