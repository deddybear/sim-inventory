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
            $table->uuid('id')->primary();
            $table->uuid('types_id')->index();
            $table->uuid('units_id')->index();
            $table->string('name',150);
            $table->unsignedInteger('qty');
            $table->unsignedInteger('price');
            $table->unsignedInteger('total');
            $table->timestamp('date_entry');
            $table->timestamp('date_out')->nullable();
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
