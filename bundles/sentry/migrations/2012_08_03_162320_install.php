<?php
/**
 * Part of the Sentry bundle for Laravel.
 *
 * NOTICE OF LICENSE
 *
 * Licensed under the 3-clause BSD License.
 *
 * This source file is subject to the 3-clause BSD License that is
 * bundled with this package in the LICENSE file.  It is also available at
 * the following URL: http://www.opensource.org/licenses/BSD-3-Clause
 *
 * @package    Sentry
 * @version    1.0
 * @author     Cartalyst LLC
 * @license    BSD License (3-clause)
 * @copyright  (c) 2011 - 2012, Cartalyst LLC
 * @link       http://cartalyst.com
 */

class Sentry_Install
{
	function __construct()
	{
		// This default password is "c0wbell!123"
		$this->users = array(
			array(
				'username' 		=> 	'admin',
				'email'			=>	'admin@rocketag.com',
				'password'		=>	'iviAREaAKjinXDV2b7e2bbbebb7304ad940c5d6c709c086fa69218b23479c6271efe3d592d8edf1d',
				'ip_address'	=> 	'127.0.0.1',
				'status'		=>	1,
				'activated'		=>	1,
				'created_at'	=> 	date(DB::grammar()->grammar->datetime),
				'updated_at'	=>	date(DB::grammar()->grammar->datetime)
			)
		);

		$this->users_metadata = array(
			'user_id'		=> '1',
			'first_name'	=> 'Admin',
			'last_name'		=> 'istrator'
		);
	}
	/**
	 * Make changes to the database.
	 *
	 * @return void
	 */
	public function up()
	{
		// Create user table
		Schema::table(Config::get('sentry::sentry.table.users'), function($table) {
			$table->on(Config::get('sentry::sentry.db_instance'));
			$table->create();
			$table->increments('id')->unsigned();
			$table->string('username');
			$table->string('email')->unique();
			$table->string('password');
			$table->string('password_reset_hash');
			$table->string('temp_password');
			$table->string('remember_me');
			$table->string('activation_hash');
			$table->string('ip_address');
			$table->string('status');
			$table->string('activated');
			$table->text('permissions');
			$table->timestamp('last_login');
			$table->timestamps();
		});

		// Create user metadata table
		Schema::table(Config::get('sentry::sentry.table.users_metadata'), function($table) {
			$table->on(Config::get('sentry::sentry.db_instance'));
			$table->create();
			$table->integer('user_id')->primary()->unsigned();
			$table->string('first_name');
			$table->string('last_name');
		});

		// Create groups table
		Schema::table(Config::get('sentry::sentry.table.groups'), function($table) {
			$table->on(Config::get('sentry::sentry.db_instance'));
			$table->create();
			$table->increments('id')->unsigned();
			$table->string('name')->unique();
			$table->text('permissions');
		});

		// Create users group relation table
		Schema::table(Config::get('sentry::sentry.table.users_groups'), function($table) {
			$table->on(Config::get('sentry::sentry.db_instance'));
			$table->create();
			$table->integer('user_id')->unsigned();
			$table->integer('group_id')->unsigned();
		});

		// Create suspension table
		Schema::table(Config::get('sentry::sentry.table.users_suspended'), function($table) {
			$table->on(Config::get('sentry::sentry.db_instance'));
			$table->create();
			$table->increments('id')->unsigned();
			$table->string('login_id');
			$table->integer('attempts');
			$table->string('ip');
			$table->timestamp('last_attempt_at');
			$table->timestamp('suspended_at');
			$table->timestamp('unsuspend_at');
		});

		foreach ($this->users as $user_row)
		{
			$id = DB::query('INSERT INTO users (`username`, `email`, `password`, `ip_address`, `status`, `activated`, `created_at`, `updated_at`) VALUES (?, ?, ?, ?, ?, ?, ?, ?)', $user_row);
			$this->users_metadata['user_id'] = $id;
			DB::query('INSERT INTO users_metadata (`user_id`, `first_name`, `last_name`) VALUES (?, ?, ?)', $this->users_metadata);
		}
	}

	/**
	 * Revert the changes to the database.
	 *
	 * @return void
	 */
	public function down()
	{
		// Drop all tables
		Schema::table(Config::get('sentry::sentry.table.users'), function($table) {
			$table->on(Config::get('sentry::sentry.db_instance'));
			$table->drop();
		});

		Schema::table(Config::get('sentry::sentry.table.users_metadata'), function($table) {
			$table->on(Config::get('sentry::sentry.db_instance'));
			$table->drop();
		});

		Schema::table(Config::get('sentry::sentry.table.groups'), function($table) {
			$table->on(Config::get('sentry::sentry.db_instance'));
			$table->drop();
		});

		Schema::table(Config::get('sentry::sentry.table.users_groups'), function($table) {
			$table->on(Config::get('sentry::sentry.db_instance'));
			$table->drop();
		});

		Schema::table(Config::get('sentry::sentry.table.users_suspended'), function($table) {
			$table->on(Config::get('sentry::sentry.db_instance'));
			$table->drop();
		});
	}

}
