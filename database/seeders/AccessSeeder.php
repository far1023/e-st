<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class AccessSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		$permissions = [
			'access control-room',
			'add spgr', 'show spgr', 'edit spgr', 'delete spgr', 'approve spgr',
			'add skt', 'show skt', 'edit skt', 'delete skt', 'approve skt',
			'add peta-situasi', 'show peta-situasi', 'edit peta-situasi', 'delete peta-situasi', 'approve peta-situasi',
			'add surat-situasi', 'show surat-situasi', 'edit surat-situasi', 'delete surat-situasi', 'approve surat-situasi',
			'access form', 'access pengguna', 'print-out'
		];

		foreach ($permissions as $item) {
			Permission::firstOrCreate(['name' => $item]);
		}

		$role = Role::where('name', '!=', 'superadmin')->get();
		foreach ($role as $item) {
			if ($item->name == 'admin kaur') {
				$granted = [2, 3, 4, 5, 7, 8, 9, 10, 12, 13, 14, 15, 17, 18, 19, 20, 22, 23];
			} else if ($item->name == 'sekdes') {
				$granted = [3, 6, 8, 11, 13, 16, 18, 21, 24];
			} else if ($item->name == 'kades') {
				$granted = [3, 6, 8, 11, 13, 16, 18, 21];
			}
			$item->syncPermissions($granted);
		}
	}
}
