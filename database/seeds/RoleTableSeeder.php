<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('roles')->insert([
            [
            	'slug' => 'administrator',
            	'name' => 'Administrator',
            	'permissions' => '{"cms.admin.create":true,"cms.admin.view":true,"cms.admin.edit":true,"cms.admin.delete":true,"cms.role.create":true,"cms.role.view":true,"cms.role.edit":true,"cms.role.delete":true,"cms.rolemanagement.create":true,"cms.user.view":true,"cms.setting.create":true,"cms.setting.view":true,"cms.setting.edit":true,"cms.setting.delete":true,"cms.dashboard":true,"cms.admin.store":true,"cms.admin.list":true,"cms.admin.update":true,"cms.role.store":true,"cms.role.list":true,"cms.role.update":true,"cms.rolemanagement.store":true,"cms.user.list":true,"cms.setting.store":true,"cms.setting.list":true,"cms.setting.update":true}',
            	'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            	'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
            	'slug' => 'user',
            	'name' => 'User',
            	'permissions' => '',
            	'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            	'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
        ]);        
    }
}
