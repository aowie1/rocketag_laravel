<?php

class Add_Fields_To_Things_Table {

	/**
	 * Make changes to the database.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('types', function($t)
		{
			$t->increments('id');
			$t->string('name');
		});

		Schema::table('things', function($t)
		{
			$t->string('source');
			$t->integer('type_id')->unsigned()->nullable();

			$t->foreign('type_id')->references('id')->on('types')->on_update('cascade')->on_delete('set null');
		});


	}

	/**
	 * Revert the changes to the database.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('types');

		Schema::table('things', function($t)
		{
			$t->drop_column('source');
			$t->drop_column('type_id');
		});
	}

}