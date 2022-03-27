<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SettingTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {   
		$timestamp = [
			'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
		];

        DB::table('settings')->insert([
			
			// admin
            [
            	'group' => 'Admin',
            	'type' => 'text',
            	'order' => '1',
            	'key' => 'admin.title',
            	'name' => 'Admin Title',
            	'value' => 'Admin',
            	'is_deletable' => 'no',
			] + $timestamp,
			[
            	'group' => 'Admin',
            	'type' => 'textarea',
            	'order' => '2',
            	'key' => 'admin.description',
            	'name' => 'Admin Description',
				'value' => 'Admin',            	
				'is_deletable' => 'no',
			] + $timestamp,
			
			// Site
            [
            	'group' => 'Site',
            	'type' => 'text',
            	'order' => '1',
            	'key' => 'site.title',
            	'name' => 'Site Title',
				'value' => 'Site App',            	
				'is_deletable' => 'no',
			] + $timestamp,

			// Meta
			[
            	'group' => 'Site',
            	'type' => 'textarea',
            	'order' => '2',
            	'key' => 'site.meta_description',
            	'name' => 'Meta Description',
				'value' => 'Admin',            	
				'is_deletable' => 'no',
			] + $timestamp,
			[
            	'group' => 'Site',
            	'type' => 'textarea',
            	'order' => '3',
            	'key' => 'site.meta_keyword',
            	'name' => 'Meta Keywords',
				'value' => 'keywords',            	
				'is_deletable' => 'no',
			] + $timestamp,
			[
            	'group' => 'Site',
            	'type' => 'text',
            	'order' => '4',
            	'key' => 'site.meta_robot',
            	'name' => 'Meta Robots',
				'value' => 'index',            	
				'is_deletable' => 'no',
			] + $timestamp,
			[
            	'group' => 'Site',
            	'type' => 'text',
            	'order' => '5',
            	'key' => 'site.meta_language',
            	'name' => 'Meta Language',
				'value' => 'english',            	
				'is_deletable' => 'no',
			] + $timestamp,
			[
            	'group' => 'Site',
            	'type' => 'image',
            	'order' => '6',
            	'key' => 'site.og_image',
            	'name' => 'OG Image',
				'value' => '',            	
				'is_deletable' => 'no',
			] + $timestamp,
        ]);
    }
}
