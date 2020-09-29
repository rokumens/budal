<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateThemesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('themes', function(Blueprint $table)
		{
			$table->bigInteger('id', true)->unsigned();
			$table->string('name', 191)->unique();
			$table->string('link', 191)->unique();
			$table->string('notes', 191)->nullable();
			$table->boolean('status')->default(1);
			$table->string('taggable_type', 191);
			$table->bigInteger('taggable_id')->unsigned();
			$table->timestamps();
			$table->softDeletes();
			$table->index(['taggable_type','taggable_id']);
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('themes');
	}

}
