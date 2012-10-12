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
		    $table->string('name', 255);
		    $table->timestamps();

		});

		// -- -----------------------------------------------------
		// -- Table `things`
		// -- -----------------------------------------------------
		// CREATE  TABLE IF NOT EXISTS `things` (
		//   `id` INT(11) NOT NULL AUTO_INCREMENT ,
		//   `name` VARCHAR(255) CHARACTER SET 'utf8' NOT NULL ,
		//   `created_ts` INT NULL ,
		//   `modified_ts` INT NULL ,
		//   PRIMARY KEY (`id`) ,
		//   UNIQUE INDEX `thing_name` (`name` ASC) )
		// ENGINE = InnoDB
		// DEFAULT CHARACTER SET = utf8;

		Schema::create('tags', function($table)
		{
		    $table->increments('id');
		    $table->string('name', 255);
			$table->timestamps();
			$table->integer('created_users_id')->nullable();
			$table->integer('modified_users_id')->nullable();
		});


		// -- -----------------------------------------------------
		// -- Table `tags`
		// -- -----------------------------------------------------
		// CREATE  TABLE IF NOT EXISTS `tags` (
		//   `id` INT(11) NOT NULL AUTO_INCREMENT ,
		//   `name` VARCHAR(255) CHARACTER SET 'utf8' NOT NULL ,
		//   `created_ts` INT NOT NULL ,
		//   `created_users_id` INT NOT NULL ,
		//   `modified_ts` INT NULL ,
		//   `modified_users_id` INT NULL ,
		//   PRIMARY KEY (`id`) ,
		//   UNIQUE INDEX `tag_name` (`name` ASC) )
		// ENGINE = InnoDB
		// AUTO_INCREMENT = 11
		// DEFAULT CHARACTER SET = utf8;

		Schema::create('things_tags_joins', function($table)
		{
		    $table->increments('id');
		    $table->integer('things_id');
		    $table->boolean('originator')->nullable()->default(0);
			$table->boolean('anonymous')->nullable()->default(0);
			$table->timestamps();
			$table->integer('tags_id');
			$table->integer('users_id')->nullable();
			$table->integer('tags_id1');
		});

		// -- -----------------------------------------------------
		// -- Table `things_tags_joins`
		// -- -----------------------------------------------------
		// CREATE  TABLE IF NOT EXISTS `tan(arg)hings_tags_joins` (
		//   `id` INT(11) NOT NULL AUTO_INCREMENT ,
		//   `things_id` INT(11) NOT NULL ,
		//   `originator` TINYINT(1) NULL DEFAULT 0 ,
		//   `anonymous` TINYINT(1) NULL DEFAULT 0 ,
		//   `created_ts` INT NULL ,
		//   `tags_id` INT(11) NOT NULL ,
		//   `users_id` INT(11) NULL ,
		//   `tags_id1` INT(11) NOT NULL ,
		//   PRIMARY KEY (`id`, `tags_id`, `things_id`, `tags_id1`) ,
		//   INDEX `fk_things_tags_joins_things1` (`things_id` ASC) ,
		//   INDEX `fk_things_tags_joins_users1` (`users_id` ASC) ,
		//   INDEX `fk_things_tags_joins_tags1` (`tags_id1` ASC) ,
		//   CONSTRAINT `fk_things_tags_joins_things1`
		//     FOREIGN KEY (`things_id` )
		//     REFERENCES `things` (`id` )
		//     ON DELETE CASCADE
		//     ON UPDATE CASCADE,
		//   CONSTRAINT `fk_things_tags_joins_users1`
		//     FOREIGN KEY (`users_id` )
		//     REFERENCES `users` (`id` )
		//     ON DELETE SET NULL
		//     ON UPDATE CASCADE,
		//   CONSTRAINT `fk_things_tags_joins_tags1`
		//     FOREIGN KEY (`tags_id1` )
		//     REFERENCES `tags` (`id` )
		//     ON DELETE CASCADE
		//     ON UPDATE CASCADE)
		// ENGINE = InnoDB
		// AUTO_INCREMENT = 6
		// DEFAULT CHARACTER SET = utf8;

		Schema::create('thing_categories', function($table)
		{
		    $table->increments('id');
		    $table->string('name', 255);
		});


		// -- -----------------------------------------------------
		// -- Table `thing_categories`
		// -- -----------------------------------------------------
		// CREATE  TABLE IF NOT EXISTS `thing_categories` (
		//   `id` INT(11) NOT NULL AUTO_INCREMENT ,
		//   `name` VARCHAR(200) NOT NULL ,
		//   PRIMARY KEY (`id`) ,
		//   UNIQUE INDEX `category_name` (`name` ASC) )
		// ENGINE = InnoDB
		// DEFAULT CHARACTER SET = utf8;


		Schema::create('spectrum', function($table)
		{
		    $table->increments('id');
		    $table->integer('value')->nullable();
			$table->timestamps();
			$table->integer('tags_id');
			$table->integer('users_id');
		});


		// -- -----------------------------------------------------
		// -- Table `spectrum`
		// -- -----------------------------------------------------
		// CREATE  TABLE IF NOT EXISTS `spectrum` (
		//   `id` INT NOT NULL AUTO_INCREMENT ,
		//   `value` INT NULL ,
		//   `tags_id` INT(11) NOT NULL ,
		//   `users_id` INT(11) NOT NULL ,
		//   `created_ts` INT NOT NULL ,
		//   `modified_ts` INT NULL ,
		//   PRIMARY KEY (`id`, `users_id`, `tags_id`) ,
		//   INDEX `fk_spectrum_tags1` (`tags_id` ASC) ,
		//   INDEX `fk_spectrum_users1` (`users_id` ASC) ,
		//   CONSTRAINT `fk_spectrum_tags1`
		//     FOREIGN KEY (`tags_id` )
		//     REFERENCES `tags` (`id` )
		//     ON DELETE CASCADE
		//     ON UPDATE CASCADE,
		//   CONSTRAINT `fk_spectrum_users1`
		//     FOREIGN KEY (`users_id` )
		//     REFERENCES `users` (`id` )
		//     ON DELETE CASCADE
		//     ON UPDATE CASCADE)
		// ENGINE = InnoDB
		// DEFAULT CHARACTER SET = utf8;

		Schema::create('categories_things_joins', function($table)
		{
		    $table->increments('id');
		    $table->integer('users_id')->nullable();
		    $table->integer('things_id');
		    $table->integer('thing_categories_id');
		});

		// -- -----------------------------------------------------
		// -- Table `categories_things_joins`
		// -- -----------------------------------------------------
		// CREATE  TABLE IF NOT EXISTS `categories_things_joins` (
		//   `id` INT NOT NULL AUTO_INCREMENT ,
		//   `users_id` INT(11) NULL ,
		//   `things_id` INT(11) NOT NULL ,
		//   `thing_categories_id` INT(11) NOT NULL ,
		//   PRIMARY KEY (`id`, `things_id`, `thing_categories_id`) ,
		//   INDEX `fk_categories_things_joins_users1` (`users_id` ASC) ,
		//   INDEX `fk_categories_things_joins_things1` (`things_id` ASC) ,
		//   INDEX `fk_categories_things_joins_thing_categories1` (`thing_categories_id` ASC) ,
		//   CONSTRAINT `fk_categories_things_joins_users1`
		//     FOREIGN KEY (`users_id` )
		//     REFERENCES `users` (`id` )
		//     ON DELETE SET NULL
		//     ON UPDATE CASCADE,
		//   CONSTRAINT `fk_categories_things_joins_things1`
		//     FOREIGN KEY (`things_id` )
		//     REFERENCES `things` (`id` )
		//     ON DELETE CASCADE
		//     ON UPDATE CASCADE,
		//   CONSTRAINT `fk_categories_things_joins_thing_categories1`
		//     FOREIGN KEY (`thing_categories_id` )
		//     REFERENCES `thing_categories` (`id` )
		//     ON DELETE CASCADE
		//     ON UPDATE CASCADE)
		// ENGINE = InnoDB
		// DEFAULT CHARACTER SET = utf8;

		Schema::create('user_suggestions', function($table)
		{
		    $table->increments('id');
		    $table->integer('things_id1');
		    $table->integer('things_id2');
		    $table->integer('users_id');
		    $table->boolean('originator')->nullable()->default(0);
		});

		// -- -----------------------------------------------------
		// -- Table `user_suggestions`
		// -- -----------------------------------------------------
		// CREATE  TABLE IF NOT EXISTS `user_suggestions` (
		//   `id` INT NOT NULL AUTO_INCREMENT ,
		//   `things_id1` INT(11) NOT NULL ,
		//   `things_id2` INT(11) NOT NULL ,
		//   `users_id` INT(11) NOT NULL ,
		//   `originator` TINYINT(1) NULL DEFAULT 0 ,
		//   `created_ts` INT NULL ,
		//   `modied_ts` INT NULL ,
		//   PRIMARY KEY (`id`, `users_id`, `things_id1`, `things_id2`) ,
		//   INDEX `fk_user_suggestions_things1` (`things_id2` ASC) ,
		//   INDEX `fk_user_suggestions_things2` (`things_id1` ASC) ,
		//   INDEX `fk_user_suggestions_users1` (`users_id` ASC) ,
		//   CONSTRAINT `fk_user_suggestions_things1`
		//     FOREIGN KEY (`things_id2` )
		//     REFERENCES `things` (`id` )
		//     ON DELETE CASCADE
		//     ON UPDATE CASCADE,
		//   CONSTRAINT `fk_user_suggestions_things2`
		//     FOREIGN KEY (`things_id1` )
		//     REFERENCES `things` (`id` )
		//     ON DELETE CASCADE
		//     ON UPDATE CASCADE,
		//   CONSTRAINT `fk_user_suggestions_users1`
		//     FOREIGN KEY (`users_id` )
		//     REFERENCES `users` (`id` )
		//     ON DELETE CASCADE
		//     ON UPDATE CASCADE)
		// ENGINE = InnoDB
		// DEFAULT CHARACTER SET = utf8;

		Schema::create('person_info', function($table)
		{
		    $table->increments('id');
		    $table->integer('things_id');
		    $table->date('birth_date');
		    $table->string('birth_location', 200);
		});

		// -- -----------------------------------------------------
		// -- Table `person_info`
		// -- -----------------------------------------------------
		// CREATE  TABLE IF NOT EXISTS `person_info` (
		//   `id` INT NOT NULL AUTO_INCREMENT ,
		//   `things_id` INT(11) NOT NULL ,
		//   `birth_date` DATETIME NOT NULL ,
		//   `birth_location` VARCHAR(200) NOT NULL ,
		//   PRIMARY KEY (`id`, `things_id`) ,
		//   INDEX `fk_person_info_things1` (`things_id` ASC) ,
		//   CONSTRAINT `fk_person_info_things1`
		//     FOREIGN KEY (`things_id` )
		//     REFERENCES `things` (`id` )
		//     ON DELETE CASCADE
		//     ON UPDATE CASCADE)
		// ENGINE = InnoDB
		// DEFAULT CHARACTER SET = utf8;

		Schema::create('comments', function($table)
		{
		    $table->increments('id');
		    $table->integer('users_id');
		    $table->string('name', 255);
		    $table->timestamps();
		    $table->string('comment', 150);
		    $table->integer('thing_tags_joins_id');
		});



		// -- -----------------------------------------------------
		// -- Table `comments`
		// -- -----------------------------------------------------
		// CREATE  TABLE IF NOT EXISTS `comments` (
		//   `id` INT NOT NULL AUTO_INCREMENT ,
		//   `users_id` INT(11) NOT NULL ,
		//   `things_tags_joins_id` INT(11) NOT NULL ,
		//   `comment` VARCHAR(150) NOT NULL ,
		//   `created_ts` INT NULL ,
		//   `modified_ts` INT NULL DEFAULT NULL ,
		//   PRIMARY KEY (`id`, `things_tags_joins_id`, `users_id`) ,
		//   INDEX `fk_comments_users1` (`users_id` ASC) ,
		//   INDEX `fk_comments_things_tags_joins1` (`things_tags_joins_id` ASC) ,
		//   CONSTRAINT `fk_comments_users1`
		//     FOREIGN KEY (`users_id` )
		//     REFERENCES `users` (`id` )
		//     ON DELETE CASCADE
		//     ON UPDATE CASCADE,
		//   CONSTRAINT `fk_comments_things_tags_joins1`
		//     FOREIGN KEY (`things_tags_joins_id` )
		//     REFERENCES `things_tags_joins` (`id` )
		//     ON DELETE CASCADE
		//     ON UPDATE CASCADE)
		// ENGINE = InnoDB
		// DEFAULT CHARACTER SET = utf8;

	}

	/**
	 * Revert the changes to the database.
	 *
	 * @return void
	 */
	public function down()
	{
		//
	}

}