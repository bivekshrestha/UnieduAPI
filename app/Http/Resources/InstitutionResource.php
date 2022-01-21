<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class InstitutionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'identifier' => $this->identifier,
            'name' => $this->name,
            'country' => $this->country,
            'route' => $this->route,
            'email' => $this->email,
            'address' => $this->address,
            'contact' => $this->contact,
            'cities' => $this->cities,
            'url' => $this->url,
            'programs' => $this->whenLoaded('programs'),
        ];
    }
}
