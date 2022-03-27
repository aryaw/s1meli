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
		'name' => 'Pengadaan',
		'fa' => 'fa-users',
		'path' => $prefix.'/pengadaan',
		'subs' => [
			[
				'name' => 'Pengadaan',
				'permission' => 'cms.pengadaan.view',
				'path' => $prefix.'/pengadaan/list',				
			],			
		]
	],

    [
		'name' => 'User',
		'fa' => 'fa-users',
		'path' => $prefix.'/user',
		'subs' => [
			[
				'name' => 'Role',								
				'permission' => 'cms.role.view',
				'path' => $prefix.'/user/role',
			],
			[
				'name' => 'Admin',				
				'permission' => 'cms.admin.view',
				'path' => $prefix.'/user/admin',				
			],
			[
				'name' => 'Role Management',								
				'permission' => 'cms.rolemanagement.create',
				'path' => $prefix.'/user/rmanagement',
			],
			[
				'name' => 'User',
				'permission' => 'cms.user.view',
				'path' => $prefix.'/user/list',				
			],			
		]
	],

	[
        'name' => 'Settings',
        'fa' => 'fa-cogs',        
        'path' => $prefix.'/setting',		
		'subs' => [
			[
				'name' => 'Setting',
				'permission' => 'cms.setting.view',
				'path' => $prefix.'/setting/list',
			],
			[
				'name' => 'Environment',
				'permission' => 'cms.environment.view',
				'path' => $prefix.'/setting/environment',
			],
		]
	],

];