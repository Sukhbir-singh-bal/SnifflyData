<?php

namespace App\Http\Resources\Api\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Str;

/** @mixin \App\Models\ScrapeRequest */
class ScrapeRequestResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'url' => $this->url,
            'status' => $this->status,
            'response_time' => $this->response_time,
            'credits_used' => $this->credits_used,
            'response_body' => $this->response_body ? Str::limit($this->response_body, 10000) : null,
            'error_message' => $this->error_message,
            'created_at' => $this->created_at,
        ];
    }
}
