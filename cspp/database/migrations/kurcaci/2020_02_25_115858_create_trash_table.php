<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTrashTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('trash');
        Schema::create('trash', function (Blueprint $table) {
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
        Schema::dropIfExists('trash');
    }
}
