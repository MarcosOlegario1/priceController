<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('items', function (Blueprint $table) {
            $table->id();
            $table->string('description', 255)->nullable();
            $table->string('url');
            $table->string('reference');
            $table->integer('reference_id');
            $table->string('price', 50)->nullable();
            $table->string('old_price', 50)->nullable();
            $table->string('mail', 50);
            $table->boolean('status')->default(1);
            $table->integer('updates') ->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('items');
    }
}
