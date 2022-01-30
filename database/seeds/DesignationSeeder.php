<?php

use Illuminate\Database\Seeder;

class DesignationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // foreach (range(1,200) as $index) {
        DB::table('designations')->insert([
            [
                'name' => 'admin',
            ],
            [
                'name' => 'management',
            ],
            [
                'name' => 'developer',
            ],
            [
                'name' => 'mediabuyer',
            ]
        ]);
    }
}
