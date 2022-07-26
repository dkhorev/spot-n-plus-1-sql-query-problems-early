<?php

declare(strict_types=1);

namespace Tests\Feature;

use Barryvdh\Debugbar\LaravelDebugbar;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Support\Facades\DB;
use Laravel\Telescope\Contracts\EntriesRepository;
use Laravel\Telescope\EntryType;
use Laravel\Telescope\Storage\EntryQueryOptions;
use Tests\TestCase;

class SampleControllerTest extends TestCase
{
    /** @test */
    public function last100_debugbar_when_correct_request_then_has_expected_resource_structure(): void
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
    public function last100_debugbar_when_correct_request_then_has_expected_query_count(): void
    {
        $this->seed(DatabaseSeeder::class);
        $debugbar = new LaravelDebugbar();
        $debugbar->boot();

        // act
        $this->getJson(route('api.last100'));

        // assert
        $queryCount = count($debugbar->collect()['queries']['statements']);
        $this->assertSame(2, $queryCount);
    }

    /** @test */
    public function last100_telescope_when_correct_request_then_has_expected_query_count(): void
    {
        // phpunit.xml: change => <env name="TELESCOPE_ENABLED" value="true"/>
        $this->seed(DatabaseSeeder::class);
        /** @var EntriesRepository $storage */
        $storage = resolve(EntriesRepository::class);

        // act
        $this->getJson(route('api.last100'));

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
    public function last100_dbquerylog_when_correct_request_then_has_expected_query_count(): void
    {
        $this->seed(DatabaseSeeder::class);

        // act
        DB::enableQueryLog();
        $this->getJson(route('api.last100'));
        DB::disableQueryLog();

        // assert
        $queryLog = DB::getQueryLog();
        $queryCount = collect($queryLog)->filter(
            fn($log) => str_contains($log['query'], 'select * from "devices" where "devices"."id"')
        )->count();
        // we expected only 1 query for all devices
        $this->assertSame(1, $queryCount);
    }
}
