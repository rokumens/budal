<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateOrchardpoolsScriptsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('orchardpools_scripts', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->string('name', 100)->nullable();
			$table->text('script', 65535)->nullable();
			$table->integer('priority')->nullable();
			$table->boolean('active')->nullable();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('orchardpools_scripts');
	}

}
