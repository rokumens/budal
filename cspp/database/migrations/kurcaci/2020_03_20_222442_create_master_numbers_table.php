<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateMasterNumbersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('master_numbers', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('phone', 25)->nullable();
			$table->string('email', 100)->nullable();
			$table->string('connect_response_by_cs', 30)->nullable();
			$table->string('campaign_result', 30)->nullable();
			$table->string('next_action_old', 30)->nullable();
			$table->text('note_contacted', 65535)->nullable();
			$table->boolean('is_assigned')->default(0);
			$table->boolean('is_contacted')->default(0);
			$table->integer('assign_to')->nullable()->index('assign_to');
			$table->integer('assigned_by')->nullable()->index('assign_by');
			$table->dateTime('assigned_date')->nullable();
			$table->dateTime('contacted_date')->nullable();
			$table->integer('category_web')->default(1)->index('category_web');
			$table->integer('category_game')->default(1)->index('category_game');
			$table->timestamp('updated_at')->nullable()->default(DB::raw('CURRENT_TIMESTAMP'));
			$table->softDeletes();
			$table->integer('deleted_by')->nullable();
			$table->integer('index_id');
			$table->integer('next_action_interested')->nullable();
			$table->integer('next_action_registered')->nullable();
			$table->integer('contacted_times')->default(0);
			$table->integer('contacted_by')->nullable();
			$table->boolean('is_interested')->default(0);
			$table->text('note_interested', 65535)->nullable();
			$table->boolean('is_deposit')->default(0);
			$table->integer('deposit_by')->nullable();
			$table->dateTime('deposit_date')->nullable();
			$table->boolean('is_registered')->default(0);
			$table->integer('registered_by')->nullable();
			$table->text('note_registered', 65535)->nullable();
			$table->dateTime('registered_date')->nullable();
			$table->integer('assigned_times')->default(0);
			$table->integer('check_1_1')->nullable()->comment('check by leader');
			$table->dateTime('check_1_2')->nullable()->comment('check date by leader');
			$table->integer('check_1_3')->nullable()->comment('check connect response by leader');
			$table->text('check_1_4', 65535)->nullable()->comment('check note by leader');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('master_numbers');
	}

}
