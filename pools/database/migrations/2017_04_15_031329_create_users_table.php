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
			$table->bigInteger('id', true)->unsigned();
			$table->string('name', 191)->nullable();
			$table->string('first_name', 191)->nullable();
			$table->string('last_name', 191)->nullable();
			$table->string('email', 191)->nullable()->unique();
			$table->dateTime('email_verified_at')->nullable();
			$table->string('password', 191);
			$table->string('remember_token', 100)->nullable();
			$table->boolean('activated')->default(0);
			$table->string('token', 191);
			$table->string('signup_ip_address', 45)->nullable();
			$table->string('signup_confirmation_ip_address', 45)->nullable();
			$table->string('signup_sm_ip_address', 45)->nullable();
			$table->string('admin_ip_address', 45)->nullable();
			$table->string('updated_ip_address', 45)->nullable();
			$table->string('deleted_ip_address', 45)->nullable();
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
