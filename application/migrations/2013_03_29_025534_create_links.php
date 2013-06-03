<?php

class Create_Links {

	/**
	 * Make changes to the database.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('links', function($table) {
			$table->increments('id');
			$table->integer('thing_id')->unsigned();
			$table->string('link');

			$table->foreign('thing_id')->references('id')->on('things')->on_update('cascade')->on_delete('cascade');
		});
	}

	/**
	 * Revert the changes to the database.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('links', function($table) {
			$table->drop();
		});
	}

}