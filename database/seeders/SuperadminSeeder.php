<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class SuperadminSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		$role = Role::create(['name' => 'superadmin']);

		$user = User::create([
			'name' => 'Administrator',
			'username' => 'superadmin',
			'password' => '$2a$12$wdgAhO/bSNvmiitg69u2Puys7QIktgnVctoy7PEcgEXZfMQsKSLwq',
			'created_at' => date('Y-m-d H:i:s'),
		]);

		$user->assignRole($role);
	}
}
