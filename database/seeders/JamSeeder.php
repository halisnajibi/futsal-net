<?php

namespace Database\Seeders;
use Illuminate\Support\Facades\DB;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class JamSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('jams')->insert([
            [
                'jam' => '07.00 - 08.00',
                'status' => '1',
            ],
            [
                'jam' => '08.00 - 09.00',
                'status' => '1'
            ],
            [
                'jam' => '09.00 - 10.00',
                'status' => '1'
            ],
            [
                'jam' => '10.00 - 11.00',
                'status' => '1'
            ],
            [
                'jam' => '11.00 - 12.00',
                'status' => '1'
            ],
            [
                'jam' => '12.00 - 13.00',
                'status' => '1'
            ],
            [
                'jam' => '13.00 - 14.00',
                'status' => '1'
            ],
            [
                'jam' => '14.00 - 15.00',
                'status' => '1'
            ],
            [
                'jam' => '15.00 - 16.00',
                'status' => '1'
            ],
            [
                'jam' => '16.00 - 17.00',
                'status' => '1'
            ],
            [
                'jam' => '17.00 - 18.00',
                'status' => '1'
            ],
            [
                'jam' => '18.00 - 19.00',
                'status' => '1'
            ],
            [
                'jam' => '19.00 - 20.00',
                'status' => '1'
            ],
            [
                'jam' => '20.00 - 21.00',
                'status' => '1'
            ],
            [
                'jam' => '21.00 - 22.00',
                'status' => '1'
            ],
            [
                'jam' => '22.00 - 23.00',
                'status' => '1'
            ],
            [
                'jam' => '23.00 - 00.00',
                'status' => '1'
            ],
        ]);
    }
}
