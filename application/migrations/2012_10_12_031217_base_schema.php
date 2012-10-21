<?php

class Base_Schema {

	/**
	 * Make changes to the database.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('things', function($table)
		{
		    $table->integer('id')->primary()->unsigned()->incrementer();
		    $table->string('name', 255);
		    $table->timestamps();
		    $table->integer('user_id')->nullable()->unsigned();

		    $table->unique('name');
		    $table->foreign('user_id')->references('id')->on('users')->on_update('cascade')->on_delete('set null');
		});

		Schema::create('tags', function($table)
		{
		    $table->integer('id')->primary()->unsigned()->incrementer();
		    $table->string('name', 255);
			$table->timestamps();
			$table->integer('user_id')->nullable()->unsigned();

			$table->unique('name');
			$table->foreign('user_id')->references('id')->on('users')->on_update('cascade')->on_delete('set null');
		});

		Schema::create('things_tags_joins', function($table)
		{
		    $table->integer('id')->primary()->unsigned()->incrementer();
		    $table->integer('user_id')->nullable()->unsigned();
		    $table->boolean('originator')->nullable()->default(0);
			$table->boolean('anonymous')->nullable()->default(0);
			$table->timestamps();
			$table->integer('things_id')->unsigned();
			$table->integer('tags_id')->unsigned();

			$table->foreign('user_id')->references('id')->on('users')->on_update('cascade')->on_delete('set null');
			$table->foreign('things_id')->references('id')->on('things')->on_update('cascade')->on_delete('cascade');
			$table->foreign('tags_id')->references('id')->on('tags')->on_update('cascade')->on_delete('cascade');
		});

		Schema::create('categories', function($table)
		{
		    $table->integer('id')->primary()->unsigned()->incrementer();
		    $table->string('name', 255);

		    $table->unique('name');
		});

		Schema::create('spectrum', function($table)
		{
		    $table->integer('id')->primary()->unsigned()->incrementer();
		    $table->integer('value')->nullable();
			$table->timestamps();
			$table->integer('user_id')->nullable()->unsigned();
			$table->integer('tags_id')->unsigned();

			$table->foreign('user_id')->references('id')->on('users')->on_update('cascade')->on_delete('set null');
			$table->foreign('tags_id')->references('id')->on('tags')->on_update('cascade')->on_delete('cascade');
		});

		Schema::create('categories_things_joins', function($table)
		{
		    $table->integer('id')->primary()->unsigned()->incrementer();
		    $table->integer('user_id')->nullable()->unsigned();
		    $table->integer('things_id')->unsigned();
		    $table->integer('categories_id')->unsigned();

		    $table->foreign('user_id')->references('id')->on('users')->on_update('cascade')->on_delete('set null');
		    $table->foreign('things_id')->references('id')->on('things')->on_update('cascade')->on_delete('cascade');
		    $table->foreign('categories_id')->references('id')->on('categories')->on_update('cascade')->on_delete('cascade');
		});

		Schema::create('user_suggestions', function($table)
		{
		    $table->integer('id')->primary()->unsigned()->incrementer();
		    $table->integer('things_id1')->unsigned();
		    $table->integer('things_id2')->unsigned();
		    $table->integer('user_id')->nullable()->unsigned();
		    $table->boolean('originator')->nullable()->default(0);

		    $table->foreign('user_id')->references('id')->on('users')->on_update('cascade')->on_delete('set null');
		    $table->foreign('things_id1')->references('id')->on('things')->on_update('cascade')->on_delete('cascade');
		    $table->foreign('things_id2')->references('id')->on('things')->on_update('cascade')->on_delete('cascade');
		});

		Schema::create('people', function($table)
		{
		    $table->integer('id')->primary()->unsigned()->incrementer();
		    $table->integer('things_id')->unsigned();
		    $table->date('birth_date');
		    $table->string('birth_location', 200);

		    $table->foreign('things_id')->references('id')->on('things')->on_update('cascade')->on_delete('cascade');
		});

		Schema::create('comments', function($table)
		{
		    $table->integer('id')->primary()->unsigned()->incrementer();
		    $table->integer('user_id')->nullable()->unsigned();
		    $table->string('name', 255);
		    $table->timestamps();
		    $table->string('comment', 150);
		    $table->integer('things_tags_joins_id')->unsigned();

		    $table->foreign('user_id')->references('id')->on('users')->on_update('cascade')->on_delete('set null');
		    $table->foreign('things_tags_joins_id')->references('id')->on('things_tags_joins')->on_update('cascade')->on_delete('cascade');
		});

	}

	/**
	 * Revert the changes to the database.
	 *
	 * @return void
	 */
	public function down()
	{

		Schema::table('comments', function($table){
			$table->drop_foreign('comments_things_tags_joins_id_foreign');
			$table->drop_foreign('comments_user_id_foreign');
			$table->drop();
		});

		Schema::table('people', function($table){
			$table->drop_foreign('people_things_id_foreign');
			$table->drop();
		});

		Schema::table('user_suggestions', function($table){
			$table->drop_foreign('user_suggestions_things_id2_foreign');
			$table->drop_foreign('user_suggestions_things_id1_foreign');
			$table->drop_foreign('user_suggestions_user_id_foreign');
			$table->drop();
		});

		Schema::table('categories_things_joins', function($table){
			$table->drop_foreign('categories_things_joins_categories_id_foreign');
			$table->drop_foreign('categories_things_joins_things_id_foreign');
			$table->drop_foreign('categories_things_joins_user_id_foreign');
			$table->drop();
		});

		Schema::table('spectrum', function($table){
			$table->drop_foreign('spectrum_tags_id_foreign');
			$table->drop_foreign('spectrum_user_id_foreign');
			$table->drop();
		});

		Schema::table('categories', function($table){
			$table->drop_unique('categories_name_unique');
			$table->drop();
		});

		Schema::table('things_tags_joins', function($table){
			$table->drop_foreign('things_tags_joins_tags_id_foreign');
			$table->drop_foreign('things_tags_joins_things_id_foreign');
			$table->drop_foreign('things_tags_joins_user_id_foreign');
			$table->drop();
		});

		Schema::table('tags', function($table){
			$table->drop_foreign('tags_user_id_foreign');
			$table->drop_unique('tags_name_unique');
			$table->drop();
		});

		Schema::table('things', function($table){
			$table->drop_foreign('things_user_id_foreign');
			$table->drop_unique('things_name_unique');
			$table->drop();
		});

	}

}