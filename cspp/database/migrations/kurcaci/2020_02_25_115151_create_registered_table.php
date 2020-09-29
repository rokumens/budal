<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRegisteredTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('registered', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('master_numbers_id');
            $table->integer('category_web')->default(1)->index('category_web');
			$table->integer('category_game')->default(1)->index('category_game');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('registered');
    }
}
