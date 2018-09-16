<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class RoleResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id'                => $this->id,
            'name'              => $this->name,
            'display_name'      => $this->display_name,
            'description'       => $this->description,
            'created_at'        => Carbon::instance(new \DateTime($this->created_at))->format('Y-m-d'),
            'updated_at'        => Carbon::instance(new \DateTime($this->updated_at))->format('Y-m-d'),

            'permissions'       => $this->perms,
        ];
    }
}
