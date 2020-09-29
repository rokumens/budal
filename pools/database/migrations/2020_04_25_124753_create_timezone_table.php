<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTimezoneTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('timezone', function(Blueprint $table)
		{
			$table->char('country_code', 3);
			$table->string('timezone', 125)->default('');
			$table->float('gmt_offset', 10)->nullable();
			$table->float('dst_offset', 10)->nullable();
			$table->float('raw_offset', 10)->nullable();
			$table->primary(['country_code','timezone']);
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('timezone');
	}

}
