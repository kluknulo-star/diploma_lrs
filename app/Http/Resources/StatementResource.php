<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use JetBrains\PhpStorm\ArrayShape;


class StatementResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array
     */
    #[ArrayShape(['content' => "string", 'id' => "int"])] public function toArray($request): array
    {
        return [
            'content' => $this->content,
            'id' => $this->statement_id,
        ];
    }
}
