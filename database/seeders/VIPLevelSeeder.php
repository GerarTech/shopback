<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class VIPLevelSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('vip_levels')->insert([
            [
                'name' => 'VIP1',
                'min_investment' => 0,
                'profit_rate' => 0.55,
                'max_tasks' => 40,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'VIP2',
                'min_investment' => 100,
                'profit_rate' => 0.65,
                'max_tasks' => 50,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'VIP3',
                'min_investment' => 300,
                'profit_rate' => 0.75,
                'max_tasks' => 60,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}

