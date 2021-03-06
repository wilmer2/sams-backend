<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePermitsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('permits', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('employee_id')->unsigned();
			$table->string('reason');
			$table->date('date_start');
			$table->date('date_end')->nullable();
			$table->date('date_cancel')->nullable();
			$table->enum('turn', ['morning', 'afternoon', 'night', 'complete'])->nullable();
			$table->string('state');
			$table->string('type');

			$table->foreign('employee_id')->references('id')->on('employees')->onDelete('cascade');
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
		Schema::drop('permits');
	}

}
