<?php

namespace Database\Seeders;

use App\Models\Unit;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UnitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Unit::insert(
            [
                [
                    'unit_id' => 1,
                    'unit_name' => 'kg'
                ],
                [
                    'unit_id' => 2,
                    'unit_name' => 'pcs'
                ],
                [
                    'unit_id' => 3,
                    'unit_name' => 'pack'
                ],
            ]
        );
    }
}
