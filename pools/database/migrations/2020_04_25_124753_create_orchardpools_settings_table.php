<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateOrchardpoolsSettingsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('orchardpools_settings', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->string('timezone');
			$table->time('countdown_stop')->nullable();
			$table->integer('min_count_reload_time')->nullable();
			$table->integer('max_count_reload_time')->nullable();
			$table->integer('time_show_max')->nullable();
			$table->string('logo')->nullable();
			$table->integer('logo_height')->nullable();
			$table->integer('logo_width')->nullable();
			$table->string('background')->nullable();
			$table->string('popup_title', 191)->nullable();
			$table->text('popup_content', 65535)->nullable();
			$table->boolean('popup_status')->nullable();
			$table->integer('popup_timeout')->nullable()->default(0);
			$table->date('launching_date')->nullable();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('orchardpools_settings');
	}

}
