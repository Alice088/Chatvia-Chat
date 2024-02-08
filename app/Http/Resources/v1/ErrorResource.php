<?php

namespace App\Http\Resources\v1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ErrorResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "ERROR"         => true,
            "ERROR_MESSAGE" => $this['ERROR_MESSAGE'],
            "ERROR_CODE"    => $this['ERROR_CODE'],
        ];
    }
}
