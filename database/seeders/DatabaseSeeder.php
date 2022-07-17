<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Device;
use App\Models\Sample;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $devices = Device::factory()->count(20)->create();
        $ids = $devices->pluck('id');

        for ($i = 0; $i < 100; $i++) {
            Sample::factory()->create([
                'device_id' => $ids->random(1)->first(),
            ]);
        }
    }
}
