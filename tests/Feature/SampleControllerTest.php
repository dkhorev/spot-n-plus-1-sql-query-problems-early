<?php

declare(strict_types=1);

namespace Tests\Feature;

use Barryvdh\Debugbar\LaravelDebugbar;
use Database\Seeders\DatabaseSeeder;
use Laravel\Telescope\Contracts\EntriesRepository;
use Laravel\Telescope\EntryType;
use Laravel\Telescope\Storage\EntryQueryOptions;
use Tests\TestCase;

class SampleControllerTest extends TestCase
{
    /** @test */
    public function last100_debugbar_when_correct_requst_then_has_expected_resource_structure(): void
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

    /** @test */
    public function last100_debugbar_when_correct_requst_then_has_expected_query_count(): void
    {
        $this->seed(DatabaseSeeder::class);
        $debugbar = new LaravelDebugbar();
        $debugbar->boot();

        // act
        $response = $this->getJson(route('api.last100'));

        // assert
        $queryCount = count($debugbar->collect()['queries']['statements']);
        $this->assertSame(2, $queryCount);
    }

    /** @test */
    public function last100_telescope_when_correct_requst_then_has_expected_query_count(): void
    {
        $this->seed(DatabaseSeeder::class);
        /** @var EntriesRepository $storage */
        $storage = resolve(EntriesRepository::class);

        // act
        $response = $this->getJson(route('api.last100'));

        // assert
        $entries = $storage->get(
            EntryType::QUERY,
            (new EntryQueryOptions())->limit(100)
        );
        // finds all queries executed in SampleResource file
        $queryCount = $entries->filter(fn($e) => str_contains($e->content['file'], 'SampleResource'))
            ->count();
        $this->assertSame(0, $queryCount);
    }

    /** @test */
    public function last100_dbquerylog_when_correct_requst_then_has_expected_query_count(): void
    {
        $this->seed(DatabaseSeeder::class);
        /** @var EntriesRepository $storage */
        $storage = resolve(EntriesRepository::class);

        // act
        $response = $this->getJson(route('api.last100'));

        // assert
        $entries = $storage->get(
            EntryType::QUERY,
            (new EntryQueryOptions())->limit(100)
        );
        // finds all queries executed in SampleResource file
        $queryCount = $entries->filter(fn($e) => str_contains($e->content['file'], 'SampleResource'))
            ->count();
        $this->assertSame(0, $queryCount);
    }
}
