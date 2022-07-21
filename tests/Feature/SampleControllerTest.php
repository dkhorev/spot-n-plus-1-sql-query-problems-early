<?php

declare(strict_types=1);

namespace Tests\Feature;

use Database\Seeders\DatabaseSeeder;
use Tests\TestCase;

class SampleControllerTest extends TestCase
{
    /** @test */
    public function last100_when_correct_requst_then_has_expected_resource_structure(): void
    {
        $this->seed(DatabaseSeeder::class);

        // act
        $response = $this->getJson(route('api.last100'));

        // assert
        $response->assertJsonStructure([
            'data' => [
                [
                    'temp',
                    'hardware_id',
                    'location',
                    'datetime',
                ],
            ],
        ]);
    }
}
