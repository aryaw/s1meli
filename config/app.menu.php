<?php
$prefix = config('app.cms.admin_prefix');

return [

	[
        'name' => 'Dashboard',
        'fa' => 'fa-tachometer',        
        'permission' => 'cms.dashboard',
        'path' => $prefix.'/dashboard' // active link indicator
    ],
	[
        'name' => 'Barang',
        'fa' => 'fa-barcode',        
        'path' => $prefix.'/barang',
        'permission' => 'cms.barang.list',
    ],
	[
		'name' => 'Laporan',
		'fa' => 'fa-users',
		'path' => $prefix.'/dashboard',
		'subs' => [
			[
				'name' => 'Pengadaan',
				'permission' => 'cms.pengadaan.view',
				'path' => $prefix.'/pengadaan/list',				
			],
			[
				'name' => 'Penerimaan',
				'permission' => 'cms.penerimaan.view',
				'path' => $prefix.'/penerimaan/list',				
			],
			[
				'name' => 'Perbaikan',
				'permission' => 'cms.perbaikan.view',
				'path' => $prefix.'/perbaikan/list',				
			],
			[
				'name' => 'Laporan Kerusakan',
				'permission' => 'cms.kerusakan.view',
				'path' => $prefix.'/kerusakan/list',				
			],
		]
	],

    [
		'name' => 'User',
		'fa' => 'fa-users',
		'path' => $prefix.'/user',
		'subs' => [
			[
				'name' => 'User Role',								
				'permission' => 'cms.role.view',
				'path' => $prefix.'/user/role',
			],
			[
				'name' => 'Role Permission',								
				'permission' => 'cms.rolemanagement.create',
				'path' => $prefix.'/user/rmanagement',
			],
			[
				'name' => 'User List',				
				'permission' => 'cms.admin.view',
				'path' => $prefix.'/user/admin',				
			],
			// [
			// 	'name' => 'User',
			// 	'permission' => 'cms.user.view',
			// 	'path' => $prefix.'/user/list',				
			// ],			
		]
	],

	// [
    //     'name' => 'Settings',
    //     'fa' => 'fa-cogs',        
    //     'path' => $prefix.'/setting',		
	// 	'subs' => [
	// 		[
	// 			'name' => 'Setting',
	// 			'permission' => 'cms.setting.view',
	// 			'path' => $prefix.'/setting/list',
	// 		],
	// 		[
	// 			'name' => 'Environment',
	// 			'permission' => 'cms.environment.view',
	// 			'path' => $prefix.'/setting/environment',
	// 		],
	// 	]
	// ],

];