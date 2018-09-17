<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class ContractResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request) {
        $pawn_date      = Carbon::instance(new \DateTime($this->pawn_date));
        $redeeming_date = (clone $pawn_date)->addDays($this->interest_period);

        return [
            'id'                    => $this->id,
            'customer'              => $this->customer,
            'commodity'             => $this->commodity,
            'commodity_id'          => $this->commodity_id,
            'customer_id'           => $this->customer_id,
            'commodity_name'        => $this->commodity_name,
            'pawn_amount'           => $this->pawn_amount,
            'interest_before_pawn'  => $this->interest_before_pawn,
            'interest_by_date'      => $this->interest_by_date,
            'interest_period'       => $this->interest_period,
            'days_of_delayed'       => $this->days_of_delayed,

            'pawn_date'             => $pawn_date->format('Y-m-d'),
            'redeeming_date'        => $redeeming_date->format('Y-m-d'),
            'remaining'             => $redeeming_date->diffInDays(Carbon::today()),

            'pawn_note'             => $this->pawn_note,
            'created_at'            => $this->created_at,
            'updated_at'            => $this->updated_at,

            'attrs'                 => json_decode($this->attrs),
            //'attrs'                 => $this->convertAttrsToResponse(),
        ];
    }

    protected function convertAttrsToResponse($attrs) {
        $result = [];
        if ($attrs != NULL) {
            foreach ($attrs as $attr) {
                $result[] = ['key' => $attr];
            }
        }
        return $result;
    }

}
