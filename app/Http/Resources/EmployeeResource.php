<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class EmployeeResource extends JsonResource
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
            'avatar'            => $this->getAvatar(),
            'username'          => $this->username,
            'email'             => $this->email,
            'activated'         => $this->activated,
            'created_at'        => Carbon::instance(new \DateTime($this->created_at))->format('Y-m-d'),
            'updated_at'        => Carbon::instance(new \DateTime($this->updated_at))->format('Y-m-d'),

            'company'           => $this->company,
        ];
    }
}
