<?php

declare(strict_types=1);

namespace App\Http\Resources;

use App\Models\Sample;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property-read Sample $resource
 */
class SampleResource extends JsonResource
{
    public function toArray($request): array|\JsonSerializable|Arrayable
    {
        return [
            'temp'        => $this->resource->temp,
            'hardware_id' => $this->resource->device?->hardware_id,
            'location'    => $this->resource->device?->location,
            'datetime'    => $this->resource->created_at,
        ];
    }
}
