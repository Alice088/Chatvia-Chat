<?php

namespace App\Http\Resources\Auth\v1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LoginResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        if ($this[ "ERROR" ]) {
            return [
                "ERROR"         => true,
                "ERROR_MESSAGE" => $this[ 'ERROR_MESSAGE' ],
                "ERROR_CODE"    => $this[ 'ERROR_CODE' ],
            ];
        } else {
            return [
                "ERROR"     => false,
                "ID"        => $this[ "USER" ]->ID,
                "USERNAME"  => $this[ "USER" ]->USERNAME,
                "CHATS_IDS" => $this[ "USER" ]->CHATS,
            ];
        }
    }
}
