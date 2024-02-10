<?php

namespace App\Http\Resources\v1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "data" => [
                "ERROR"     => false,
                "ID"        => $this["USER"]->ID,
                "USERNAME"  => $this["USER"]->USERNAME,
                "CHATS_IDS" => $this["USER"]->CHATS,
            ]
        ];
    }
}