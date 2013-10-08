<?php

class Create_Votes_Table {

	/**
	 * Make changes to the database.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('votes', function($table){
			$table->increments('id');
			$table->integer('user_id')->unsigned()->nullable();
			$table->integer('thing_id')->unsigned();
			$table->integer('vote_value');
			$table->timestamps();

			$table->foreign('thing_id')->references('id')->on('things')->on_update('cascade')->on_delete('cascade');
			$table->foreign('user_id')->references('id')->on('users')->on_delete('set null')->on_update('cascade');
		});
	}

	/**
	 * Revert the changes to the database.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('votes', function($table){
			$table->drop_foreign('votes_user_id_foreign');

			$table->drop();
		});
	}

}