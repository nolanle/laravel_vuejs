<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class CompanyResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request) {
        return [
            'id'                => $this->id,
            'name'              => $this->name,
            'phone'             => $this->phone,
            'address'           => $this->address,
            'address_addition'  => $this->address_addition,
            'represent'         => $this->represent,
            'activated'         => $this->activated,

            'initial_capital'   => $this->getInitialCapital(),
            'current_balance'   => $this->getCurrentBalance(),

            'created_at'        => Carbon::instance(new \DateTime($this->created_at))->format('Y-m-d'),
            'updated_at'        => Carbon::instance(new \DateTime($this->updated_at))->format('Y-m-d'),

            'district'          => new DistrictResource($this->district),
        ];
    }
}
