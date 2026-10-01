<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SesionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "type" => "sesion",
            "id" => $this->id,
            "attributes" => [
                "start_time" => $this->start_time,
                "end_time" => $this->end_time,
                "status" => $this->status,
            ],
            "relationships" => [
                "user" => [
                    "data" => [
                        "type" => "user",
                        "id" => $this->user_id,
                    ],
                ],
                "patient" => new PatientResource($this->whenLoaded("patient")),
            ],
            "can" => [
                "view" => $request->user()->can("view", $this->resource),
                "update" => $request->user()->can("update", $this->resource),
                "delete" => $request->user()->can("delete", $this->resource),
            ],
        ];
    }
}
