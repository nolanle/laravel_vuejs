<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class CommodityResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request) {
        return [
            'id'                        => $this->id,
            'name'                      => $this->name,
            'code'                      => $this->code,
            'mortgage_amount'           => $this->mortgage_amount,
            'interest_before_mortgage'  => $this->interest_before_mortgage,
            'interest_by_date'          => $this->interest_by_date,
            'interest_period'           => $this->interest_period,
            'days_of_delayed'           => $this->days_of_delayed,
            'activated'                 => $this->activated,

            'created_at'                => Carbon::instance(new \DateTime($this->created_at))->format('Y-m-d'),
            'updated_at'                => Carbon::instance(new \DateTime($this->updated_at))->format('Y-m-d'),

            //'attrs'                     => $this->attrs,
            'attrs'                     => $this->convertAttrsToResponse(json_decode($this->attrs)),
        ];
    }

    protected function convertAttrsToResponse($attrs) {
        $result = [];
        foreach ($attrs as $attr) {
            $result[] = ['key' => $attr];
        }
        return $result;
    }
}
