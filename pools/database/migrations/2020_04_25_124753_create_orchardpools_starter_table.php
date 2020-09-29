<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateOrchardpoolsStarterTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('orchardpools_starter', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->string('number', 6)->nullable();
			$table->dateTime('time_show')->nullable();
			$table->integer('prize')->nullable();
			$table->integer('draw_id')->nullable();
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
		Schema::drop('orchardpools_starter');
	}

}
