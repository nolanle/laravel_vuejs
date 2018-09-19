<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class TransactionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request) {
        $typeText = '';
        switch ($this->type) {
            case 'initial':
                $typeText = "Vốn khởi tạo";
                break;
            case 'pawning':
                $typeText = "Chi hợp đồng";
                break;
            case 'paid_fee':
                $typeText = "Trả phí";
                break;
            case 'liquidate':
                $typeText = "Thanh lý";
                break;
            case 'refund':
                $typeText = "Hủy hợp đồng";
                break;
            case 'deposit':
                $typeText = "Thêm vốn";
                break;
            case 'withdraw':
                $typeText = "Xuất vốn";
                break;
            case 'other':
                if ($this->addition) {
                    $typeText = "Thu khác";
                }
                else {
                    $typeText = "Chi khác";
                }
                break;
        }
        return [
            'id'                => $this->id,
            'type_text'         => $typeText,
            'addition'          => $this->addition,
            'contract'          => $this->contract,
            'company'           => $this->company,
            'amount'            => $this->amount,
            'description'       => $this->description,
            'created_at'        => Carbon::instance(new \DateTime($this->created_at))->format('Y-m-d'),
        ];
    }
}
