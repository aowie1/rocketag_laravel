<?php

class Add_User_Id_To_Links {

	/**
	 * Make changes to the database.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('links', function($table){
			$table->integer('user_id')->unsigned()->nullable();
			$table->timestamps();

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
		Schema::table('links', function($table){
			$table->drop_foreign('links_user_id_foreign');

			$table->drop_column(array('user_id', 'created_at', 'updated_at'));
		});
	}

}