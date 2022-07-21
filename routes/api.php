<?php

declare(strict_types=1);

use App\Http\Controllers\SampleController;

Route::get('last100', [SampleController::class, 'last100'])->name('api.last100');
