<?php

namespace Database\Seeders;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Topup;
use Illuminate\Database\Seeder;

class UsersAndTopupsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::factory()->count(500)->create();

        for ($i = 0; $i < 3; $i++) {
            $date = Carbon::now()->subDays($i);
            $topups = [];

            for ($j = 0; $j < 200000; $j++) {
                $topups[] = [
                    'user_id' => rand(1, 500),
                    'amount' => rand(10, 1000),
                    'created_at' => $date->copy()->addSeconds(rand(0, 86400)),
                    'updated_at' => $date->copy()->addSeconds(rand(0, 86400))
                ];
            }

            Topup::insert($topups);
        }

    }
}
