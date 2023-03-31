<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		User::create([
			'name' => 'Administrator',
			'username' => 'superadmin',
			'password' => '$2y$10$TUC4pP7L.bXMnyGyL1/UVe6npXHuxyDP6AZ2Ziq47JgtG42pbWkAK',
			'created_at' => date('Y-m-d H:i:s'),
		])->assignRole(1);

		User::create([
			'name' => 'Kak Kaur',
			'username' => 'kaur1',
			'password' => '$2y$10$TUC4pP7L.bXMnyGyL1/UVe6npXHuxyDP6AZ2Ziq47JgtG42pbWkAK',
			'created_at' => date('Y-m-d H:i:s'),
		])->assignRole(2);

		User::create([
			'name' => 'Sekdes Manjiw',
			'username' => 'sekdes1',
			'password' => '$2y$10$TUC4pP7L.bXMnyGyL1/UVe6npXHuxyDP6AZ2Ziq47JgtG42pbWkAK',
			'created_at' => date('Y-m-d H:i:s'),
		])->assignRole(3);

		User::create([
			'name' => 'Kepala Desa Pilihan',
			'username' => 'kades1',
			'password' => '$2y$10$TUC4pP7L.bXMnyGyL1/UVe6npXHuxyDP6AZ2Ziq47JgtG42pbWkAK',
			'created_at' => date('Y-m-d H:i:s'),
		])->assignRole(4);
	}
}
