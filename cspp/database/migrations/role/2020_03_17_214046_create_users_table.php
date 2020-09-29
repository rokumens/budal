<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateUsersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('users', function(Blueprint $table)
		{
			$table->bigIncrements('id');
			$table->string('nik', 20);
			$table->string('name', 191)->unique()->comment('used for username');
			$table->string('email', 191)->nullable()->unique();
			$table->string('password', 191);
			$table->string('remember_token', 100)->nullable();
			$table->bigInteger('created_by')->nullable();
			$table->bigInteger('updated_by')->nullable();
			$table->bigInteger('deleted_by')->nullable();
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
		Schema::drop('users');
	}

}
