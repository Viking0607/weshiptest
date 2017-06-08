<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class ParcelTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('parcels')->insert([
            'user_id' => 1,
            'track' => 's12345-6789',
            'weight' => 0,
            'shop' => 'Coolshop',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),

        ]);

        DB::table('parcels')->insert([
            'user_id' => 2,
            'track' => 'e12345-6789',
            'weight' => 0,
            'shop' => 'Very cool shop',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),

        ]);

        DB::table('parcels')->insert([
            'user_id' => 1,
            'track' => 's98765-4321',
            'weight' => 0,
            'shop' => 'Very cool shop 2',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),

        ]);
    }
}
