<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Resources\SampleResource;
use App\Models\Sample;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class SampleController extends Controller
{
    public function last100(): AnonymousResourceCollection
    {
        return SampleResource::collection(
        // Sample::latest()->limit(100)->get() // a broken query
            Sample::latest()->with(['device'])->limit(100)->get() // a fixed query
        );
    }
}
