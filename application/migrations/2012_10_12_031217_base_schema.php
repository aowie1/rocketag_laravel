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
		    $table->increments('id');
		    $table->string('name', 50);
		    $table->string('slug', 50);
		    $table->timestamps();
		    $table->integer('user_id')->nullable()->unsigned();

		    $table->unique('name');
		    $table->unique('slug');
		    $table->foreign('user_id')->references('id')->on('users')->on_update('cascade')->on_delete('set null');
		});

		Schema::create('tags', function($table)
		{
		    $table->increments('id');
		    $table->string('name', 24);
			$table->timestamps();
			$table->integer('user_id')->nullable()->unsigned();

			$table->unique('name');
			$table->foreign('user_id')->references('id')->on('users')->on_update('cascade')->on_delete('set null');
		});

		Schema::create('tag_thing', function($table)
		{
		    $table->increments('id');
		    $table->integer('user_id')->nullable()->unsigned();
		    $table->boolean('originator')->nullable()->default(0);
			$table->boolean('anonymous')->nullable()->default(0);
			$table->timestamps();
			$table->integer('thing_id')->unsigned();
			$table->integer('tag_id')->unsigned();

			$table->foreign('user_id')->references('id')->on('users')->on_update('cascade')->on_delete('set null');
			$table->foreign('thing_id')->references('id')->on('things')->on_update('cascade')->on_delete('cascade');
			$table->foreign('tag_id')->references('id')->on('tags')->on_update('cascade')->on_delete('cascade');
		});

		Schema::create('categories', function($table)
		{
		    $table->increments('id');
		    $table->string('name', 255);

		    $table->unique('name');
		});

		Schema::create('spectrum', function($table)
		{
		    $table->increments('id');
		    $table->integer('value')->nullable();
			$table->timestamps();
			$table->integer('user_id')->nullable()->unsigned();
			$table->integer('tag_id')->unsigned();

			$table->foreign('user_id')->references('id')->on('users')->on_update('cascade')->on_delete('set null');
			$table->foreign('tag_id')->references('id')->on('tags')->on_update('cascade')->on_delete('cascade');
		});

		Schema::create('category_thing', function($table)
		{
		    $table->increments('id');
		    $table->integer('user_id')->nullable()->unsigned();
		    $table->integer('thing_id')->unsigned();
		    $table->integer('category_id')->unsigned();

		    $table->foreign('user_id')->references('id')->on('users')->on_update('cascade')->on_delete('set null');
		    $table->foreign('thing_id')->references('id')->on('things')->on_update('cascade')->on_delete('cascade');
		    $table->foreign('category_id')->references('id')->on('categories')->on_update('cascade')->on_delete('cascade');
		});

		Schema::create('user_suggestions', function($table)
		{
		    $table->increments('id');
		    $table->integer('thing_id1')->unsigned();
		    $table->integer('thing_id2')->unsigned();
		    $table->integer('user_id')->nullable()->unsigned();
		    $table->boolean('originator')->nullable()->default(0);

		    $table->foreign('user_id')->references('id')->on('users')->on_update('cascade')->on_delete('set null');
		    $table->foreign('thing_id1')->references('id')->on('things')->on_update('cascade')->on_delete('cascade');
		    $table->foreign('thing_id2')->references('id')->on('things')->on_update('cascade')->on_delete('cascade');
		});

		Schema::create('people', function($table)
		{
		    $table->increments('id');
		    $table->integer('thing_id')->unsigned();
		    $table->date('birth_date');
		    $table->string('birth_location', 200);

		    $table->foreign('thing_id')->references('id')->on('things')->on_update('cascade')->on_delete('cascade');
		});

		Schema::create('comments', function($table)
		{
		    $table->increments('id');
		    $table->integer('user_id')->nullable()->unsigned();
		    $table->string('name', 255);
		    $table->timestamps();
		    $table->string('comment', 150);
		    $table->integer('tag_thing_id')->unsigned();

		    $table->foreign('user_id')->references('id')->on('users')->on_update('cascade')->on_delete('set null');
		    $table->foreign('tag_thing_id')->references('id')->on('tag_thing')->on_update('cascade')->on_delete('cascade');
		});

		Schema::create('images', function($table){
			$table->increments('id');
			$table->integer('thing_id')->unsigned();
			$table->string('image', 255);
			$table->integer('user_id')->nullable()->unsigned();
			$table->timestamps();
			$table->integer('relevance');

		    $table->foreign('user_id')->references('id')->on('users')->on_update('cascade')->on_delete('set null');
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
		Schema::table('images', function($table){
			$table->drop_foreign('images_thing_id_foreign');
			$table->drop_foreign('images_user_id_foreign');
			$table->drop();
		});

		Schema::table('comments', function($table){
			$table->drop_foreign('comments_tag_thing_id_foreign');
			$table->drop_foreign('comments_user_id_foreign');
			$table->drop();
		});

		Schema::table('people', function($table){
			$table->drop_foreign('people_thing_id_foreign');
			$table->drop();
		});

		Schema::table('user_suggestions', function($table){
			$table->drop_foreign('user_suggestions_thing_id2_foreign');
			$table->drop_foreign('user_suggestions_thing_id1_foreign');
			$table->drop_foreign('user_suggestions_user_id_foreign');
			$table->drop();
		});

		Schema::table('category_thing', function($table){
			$table->drop_foreign('category_thing_category_id_foreign');
			$table->drop_foreign('category_thing_thing_id_foreign');
			$table->drop_foreign('category_thing_user_id_foreign');
			$table->drop();
		});

		Schema::table('spectrum', function($table){
			$table->drop_foreign('spectrum_tag_id_foreign');
			$table->drop_foreign('spectrum_user_id_foreign');
			$table->drop();
		});

		Schema::table('categories', function($table){
			$table->drop_unique('categories_name_unique');
			$table->drop();
		});

		Schema::table('tag_thing', function($table){
			$table->drop_foreign('tag_thing_tag_id_foreign');
			$table->drop_foreign('tag_thing_thing_id_foreign');
			$table->drop_foreign('tag_thing_user_id_foreign');
			$table->drop();
		});

		Schema::table('tags', function($table){
			$table->drop_foreign('tags_user_id_foreign');
			$table->drop_unique('tags_name_unique');
			$table->drop();
		});

		Schema::table('things', function($table){
			$table->drop_foreign('things_user_id_foreign');
			$table->drop_unique('things_slug_unique');
			$table->drop_unique('things_name_unique');
			$table->drop();
		});

	}

}