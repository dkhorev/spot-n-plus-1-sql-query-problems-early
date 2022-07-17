<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Device;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Sample>
 */
class SampleFactory extends Factory
{
    public function definition(): array
    {
        return [
            'device_id' => fn(array $self) => $self['device_id'] ?? Device::factory()->create(),
            'temp'      => fake()->numberBetween(-10, 30),
        ];
    }
}
