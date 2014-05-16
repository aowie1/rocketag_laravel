<?php

class Add_Votes_Field_To_Tag_Thing {

	/**
	 * Make changes to the database.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('tag_thing', function($t){
			$t->integer('votes')->default(0);
		});
	}

	/**
	 * Revert the changes to the database.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('tag_thing', function($t){
			$t->drop_column('votes');
		});
	}

}