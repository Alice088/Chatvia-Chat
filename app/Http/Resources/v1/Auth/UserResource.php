<?php

namespace App\Http\Resources\v1\Auth;

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
        try {
            $resource = [
                "data" => [
                    "ERROR"    => false,
                    "ID"       => $this["USER"]->USER_ID,
                    "USERNAME" => $this["USER"]->USERNAME,
                    "CHATS"    => $this["USER"]->CHATS,
                ]
            ];

            return $resource;
        } catch (\Exception $error) {
            return [
                "ERROR"         => true,
                "ERROR_MESSAGE" => "Something went wrong",
                "ERROR_CODE"    => 500,
            ];
        }
    }
}

