<?php

namespace Database\Seeders;

use App\Models\Feed;
use Illuminate\Database\Seeder;

class FeedSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 1; $i <= 10; $i++) {
            Feed::create([
                'consumer_id' => 1,
                'message' => 'Lorem ipsum dolor sit amet'
            ]);
        }
    }
}
