<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateOrchardpoolsSeoTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('orchardpools_seo', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->string('menu_name', 50)->nullable();
			$table->string('title', 50)->nullable();
			$table->string('keyword')->nullable();
			$table->text('description', 65535)->nullable();
			$table->string('canonical')->nullable();
			$table->string('url')->nullable();
			$table->string('property')->nullable();
			$table->string('image')->nullable();
			$table->timestamps();
			$table->text('content', 65535)->nullable();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('orchardpools_seo');
	}

}
