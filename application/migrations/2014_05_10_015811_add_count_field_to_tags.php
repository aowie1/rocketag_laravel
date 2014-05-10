<?php

class Add_Count_Field_To_Tags {

	/**
	 * Make changes to the database.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('tags', function($t){
			$t->integer('active_count')->default(0);
		});
	}

	/**
	 * Revert the changes to the database.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('tags', function($t){
			$t->drop_column('active_count');
		});
	}

}