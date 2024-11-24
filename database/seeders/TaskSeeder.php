<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Task; // Ensure this is at the top
use Faker\Factory as Faker;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;



class TaskSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();

        for ($i = 0; $i < 100; $i++) {
            DB::table('tasks')->insert([
                'title' => $faker->sentence,  // Random title
                'description' => $faker->paragraph,  // Random description
                'due_date' => $faker->dateTimeBetween('now', '+5 year')->format('Y-m-d H:i:s'),  // Random due date in the future
                'priority' => $faker->randomElement(['low', 'medium', 'high']),  // Random priority
                'status' => $faker->randomElement(['pending', 'in_progress', 'completed']),  // Random status
                'category_id' => $faker->numberBetween(1, 4),  // Random category_id (assuming you have categories with ids 1-4)
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
