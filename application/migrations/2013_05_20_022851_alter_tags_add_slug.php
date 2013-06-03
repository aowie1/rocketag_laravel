<?php

class Alter_Tags_Add_Slug {

	/**
	 * Make changes to the database.
	 *
	 * @return void
	 */
	public function up()
	{

		Schema::table('tags', function($table){
			$table->string('slug')->unique('slug');
		});
	}

	/**
	 * Revert the changes to the database.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('tags', function($table){
			$table->drop_column('slug');
		});
	}

}