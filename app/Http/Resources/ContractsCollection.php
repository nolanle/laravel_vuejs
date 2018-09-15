<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\ResourceCollection;

class ContractsCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request) {
        $result = [];
        foreach ($this->collection as $item) {
            $pawn_date = Carbon::instance(new \DateTime($item->pawn_date));
            $redeeming_date = $pawn_date->addDays($item->interest_period);
            $result[] = [
                'id'                    => $item->id,
                'customer'              => $item->customer,
                'commodity'             => $item->commodity,
                'commodity_name'        => $item->commodity_name,
                'pawn_amount'           => $item->pawn_amount,
                'interest_before_pawn'  => $item->interest_before_pawn,
                'interest_by_date'      => $item->interest_by_date,
                'interest_period'       => $item->interest_period,
                'days_of_delayed'       => $item->days_of_delayed,
                'pawn_date'             => $pawn_date->format('Y-m-d'),
                'redeeming_date'        => $redeeming_date->format('Y-m-d'),
                'remaining'             => $redeeming_date->diffInDays(Carbon::today()),
                'pawn_note'             => $item->pawn_note,
                'created_at'            => $item->created_at,
                'updated_at'            => $item->updated_at,
            ];
        }
        //asort($result);
        return $result;
    }
}
