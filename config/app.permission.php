<?php
return [
	// admin
	[
		'name' => 'Admin',
		'code' => 'admin',
		'parent' => '0'
	],
		[
			'name' => 'Create Admin',
			'code' => 'cms.admin.create',
			'parent' => 'admin'
		],
		[
			'name' => 'Admin List',
			'code' => 'cms.admin.view',
			'parent' => 'admin'
		],
		[
			'name' => 'Update Admin',
			'code' => 'cms.admin.edit',
			'parent' => 'admin'
		],
		[
			'name' => 'Delete Admin',
			'code' => 'cms.admin.delete',
			'parent' => 'admin'
		],

	// role
	[
		'name' => 'Role',
		'code' => 'role',
		'parent' => '0'
	],
		[
			'name' => 'Create Role',
			'code' => 'cms.role.create',
			'parent' => 'role'
		],
		[
			'name' => 'Role List',
			'code' => 'cms.role.view',
			'parent' => 'role'
		],
		[
			'name' => 'Update Role',
			'code' => 'cms.role.edit',
			'parent' => 'role'
		],
		[
			'name' => 'Delete Role',
			'code' => 'cms.role.delete',
			'parent' => 'role'
		],


	// role management
	[
		'name' => 'Role Management',
		'code' => 'rolemanagement',
		'parent' => '0'
	],
		[
			'name' => 'Manage Role Management',
			'code' => 'cms.rolemanagement.create',
			'parent' => 'rolemanagement'
		],


	// user
	[
		'name' => 'User',
		'code' => 'user',
		'parent' => '0'
	],	
		[
			'name' => 'User List',
			'code' => 'cms.user.view',
			'parent' => 'user'
		],
		[
			'name' => 'Delete User',
			'code' => 'cms.user.delete',
			'parent' => 'user'
		],
		[
			'name' => 'Create user',
			'code' => 'cms.user.create',
			'parent' => 'user'
		],
		[
			'name' => 'Update user',
			'code' => 'cms.user.edit',
			'parent' => 'user'
		],
		[
			'name' => 'Update user password',
			'code' => 'cms.user.editpasswd',
			'parent' => 'user'
		],
		[
			'name' => 'Update user data',
			'code' => 'cms.user.update',
			'parent' => 'user'
		],
		[
			'name' => 'Update user password data',
			'code' => 'cms.user.updatepasswd',
			'parent' => 'user'
		],
		// [
		// 	'name' => 'Simpan user',
		// 	'code' => 'cms.user.edit',
		// 	'parent' => 'user'
		// ],

	// setting
	[
		'name' => 'Setting',
		'code' => 'setting',
		'parent' => '0'
	],
		[
			'name' => 'Create Setting',
			'code' => 'cms.setting.create',
			'parent' => 'setting'
		],
		[
			'name' => 'Setting List',
			'code' => 'cms.setting.view',
			'parent' => 'setting'
		],
		[
			'name' => 'Update Setting',
			'code' => 'cms.setting.edit',
			'parent' => 'setting'
		],
		[
			'name' => 'Delete Setting',
			'code' => 'cms.setting.delete',
			'parent' => 'setting'
		],
	
	// pengadaan
	[
		'name' => 'Pengadaan',
		'code' => 'pengadaan',
		'parent' => '0'
	],
		[
			'name' => 'Create Pengadaan',
			'code' => 'cms.pengadaan.create',
			'parent' => 'pengadaan'
		],
		[
			'name' => 'Pengadaan List',
			'code' => 'cms.pengadaan.view',
			'parent' => 'pengadaan'
		],
		[
			'name' => 'Update Pengadaan',
			'code' => 'cms.pengadaan.edit',
			'parent' => 'pengadaan'
		],
		[
			'name' => 'Approval Pengadaan',
			'code' => 'cms.pengadaan.show',
			'parent' => 'pengadaan'
		],
		[
			'name' => 'Simpan Pengadaan',
			'code' => 'cms.pengadaan.store',
			'parent' => 'pengadaan'
		],
		[
			'name' => 'Simpan Pengadaan Detail',
			'code' => 'cms.pengadaan.updatebyrole',
			'parent' => 'pengadaan'
		],
		[
			'name' => 'Delete Pengadaan',
			'code' => 'cms.pengadaan.delete',
			'parent' => 'pengadaan'
		],

	// penerimaan
	[
		'name' => 'Penerimaan',
		'code' => 'penerimaan',
		'parent' => '0'
	],
		[
			'name' => 'Create Penerimaan',
			'code' => 'cms.penerimaan.create',
			'parent' => 'penerimaan'
		],
		[
			'name' => 'Penerimaan List',
			'code' => 'cms.penerimaan.view',
			'parent' => 'penerimaan'
		],
		[
			'name' => 'Update Penerimaan',
			'code' => 'cms.penerimaan.edit',
			'parent' => 'penerimaan'
		],
		[
			'name' => 'Approval Penerimaan',
			'code' => 'cms.penerimaan.show',
			'parent' => 'penerimaan'
		],
		[
			'name' => 'Simpan Penerimaan',
			'code' => 'cms.penerimaan.store',
			'parent' => 'penerimaan'
		],
		[
			'name' => 'Simpan Penerimaan Detail',
			'code' => 'cms.penerimaan.updatebyrole',
			'parent' => 'penerimaan'
		],
		[
			'name' => 'Delete Penerimaan',
			'code' => 'cms.penerimaan.delete',
			'parent' => 'penerimaan'
		],

		[
			'name' => 'Update Nota Penerimaan',
			'code' => 'cms.penerimaan.editnota',
			'parent' => 'penerimaan'
		],
		[
			'name' => 'Simpan Nota Penerimaan',
			'code' => 'cms.penerimaan.updatenota',
			'parent' => 'penerimaan'
		],
	
	// perbaikan
	[
		'name' => 'Perbaikan',
		'code' => 'perbaikan',
		'parent' => '0'
	],
		[
			'name' => 'Create Perbaikan',
			'code' => 'cms.perbaikan.create',
			'parent' => 'perbaikan'
		],
		[
			'name' => 'Perbaikan List',
			'code' => 'cms.perbaikan.view',
			'parent' => 'perbaikan'
		],
		[
			'name' => 'Update Perbaikan',
			'code' => 'cms.perbaikan.edit',
			'parent' => 'perbaikan'
		],
		[
			'name' => 'Approval Perbaikan',
			'code' => 'cms.perbaikan.show',
			'parent' => 'perbaikan'
		],
		[
			'name' => 'Simpan Perbaikan',
			'code' => 'cms.perbaikan.store',
			'parent' => 'perbaikan'
		],
		[
			'name' => 'Simpan Perbaikan Detail',
			'code' => 'cms.perbaikan.updatebyrole',
			'parent' => 'perbaikan'
		],
		[
			'name' => 'Delete Perbaikan',
			'code' => 'cms.perbaikan.delete',
			'parent' => 'perbaikan'
		],

	// kerusakan
	[
		'name' => 'Laporan Kerusakan',
		'code' => 'kerusakan',
		'parent' => '0'
	],
		[
			'name' => 'Create Laporan Kerusakan',
			'code' => 'cms.kerusakan.create',
			'parent' => 'kerusakan'
		],
		[
			'name' => 'Laporan Kerusakan List',
			'code' => 'cms.kerusakan.view',
			'parent' => 'kerusakan'
		],
		[
			'name' => 'Update Laporan Kerusakan',
			'code' => 'cms.kerusakan.edit',
			'parent' => 'kerusakan'
		],
		[
			'name' => 'Approval Laporan Kerusakan',
			'code' => 'cms.kerusakan.show',
			'parent' => 'kerusakan'
		],
		[
			'name' => 'Simpan Laporan Kerusakan',
			'code' => 'cms.kerusakan.store',
			'parent' => 'kerusakan'
		],
		[
			'name' => 'Simpan Laporan Kerusakan Detail',
			'code' => 'cms.kerusakan.updatebyrole',
			'parent' => 'kerusakan'
		],
		[
			'name' => 'Delete Laporan Kerusakan',
			'code' => 'cms.kerusakan.delete',
			'parent' => 'kerusakan'
		],

	// environment
	/* [
		'name' => 'Environment',
		'code' => 'environment',
		'parent' => '0'
	],
		[
			'name' => 'Create Environment',
			'code' => 'cms.environment.create',
			'parent' => 'environment'
		],
		[
			'name' => 'Environment List',
			'code' => 'cms.environment.view',
			'parent' => 'environment'
		],
		[
			'name' => 'Update Environment',
			'code' => 'cms.environment.edit',
			'parent' => 'environment'
		],
		[
			'name' => 'Delete Environment',
			'code' => 'cms.environment.delete',
			'parent' => 'environment'
		],
		[
			'name' => 'Change Environment',
			'code' => 'cms.environment.change',
			'parent' => 'environment'
		], */

];
