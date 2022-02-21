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
            $table->id('id');
            $table->string('item_code')->nullable();
            $table->uuid('types_id')->index();
            $table->uuid('units_id')->index();
            $table->string('name',150);
            $table->unsignedInteger('qty');
            $table->unsignedDecimal('price', 13, 0);
            $table->unsignedDecimal('total', 13, 0);
            $table->timestamp('date_entry')->nullable();
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
