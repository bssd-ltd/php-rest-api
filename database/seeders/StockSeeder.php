<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StockSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('stocks')->insert([
            'name' => 'Play station 5',
            'code' => 'PS5',
            'amount' => 10,
        ]);
        DB::table('stocks')->insert([
            'name' => 'Microsoft Xbox One',
            'code' => 'XBOXONE',
            'amount' => 10,
        ]);
    }
}
