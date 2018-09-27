<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SumResource extends JsonResource
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
            'beginning_balance' => $this->beginning_balance,
            'ending_balance'    => $this->ending_balance,
            'total_revenue'     => $this->total_revenue,
            'total_cost'        => $this->total_cost,
            'arising_date'      => $this->arising_date,
            'company_id'        => $this->company_id,
            'created_at'        => $this->created_at,
            'updated_at'        => $this->updated_at,
            'deleted_at'        => $this->deleted_at,

            'company'           => $this->company,
        ];
    }
}
