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

            // calculator
            'pawn_days'             => $this->getPawnDays(),
            'pawn_fee_amount'       => $this->getPawnFeeAmount(),
            'out_of_date'           => $this->getOutOfDate(),
            'out_of_date_days'      => $this->getOutOfDateDays(),

            'pawn_date'             => $this->getPawnDate(),
            'redeeming_date'        => $this->getRemainingDate(),
            'remaining'             => $this->getRemainingDays(),

            'total_paid'            => $this->getTotalPaid(json_decode($this->histories)),

            // checking
            'can_paid'              => $this->interest_before_pawn == 1 || $this->getOutOfDate() || $this->paid_date != null,
            'can_renew'             => $this->getOutOfDate() || $this->paid_date == null,
            'can_liquidate'         => $this->liquidate_date != null,

            'paid_date'             => $this->paid_date,
            'renew_date'            => $this->renew_date,
            'liquidate_date'        => $this->liquidate_date,

            'pawn_note'             => $this->pawn_note,
            'created_at'            => $this->created_at,
            'updated_at'            => $this->updated_at,

            // Access Json
            'attrs'                 => json_decode($this->attrs),
            'histories'             => json_decode($this->histories),

        ];
    }

    protected function getTotalPaid($histories) {
        $totalPaid = 0;

        if ($histories != NULL) {
            foreach ($histories as $history) {
                $totalPaid += $history->amount;
            }
        }
        return $totalPaid;
    }

}
