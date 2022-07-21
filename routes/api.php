<?php

declare(strict_types=1);

use App\Http\Controllers\SampleController;

Route::post('last100', [SampleController::class, 'last100']);
