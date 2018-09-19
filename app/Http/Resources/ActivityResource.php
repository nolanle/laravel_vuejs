<?php

namespace App\Http\Resources;

use App\Models\Company;
use App\Models\Contract;
use App\Models\Customer;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class ActivityResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        // return parent::toArray($request);
        $company    = Company::withTrashed()->find($this->getExtraProperty('company_id'));
        $contract   = Contract::withTrashed()->find($this->getExtraProperty('contract_id'));
        $customer   = $contract->customer;
        $employee   = User::find($this->causer_id);
        $createdAt  = Carbon::instance(new \DateTime($this->created_at, new \DateTimeZone('Asia/Ho_Chi_Minh')));

        return [
            'id'            => $this->id,
            'title'         => $this->description,
            'action'        => $this->getExtraProperty('action'),
            'company'       => $company,
            'contract'      => $contract,
            'customer'      => $customer,
            'employee'      => $employee,
            'message'       =>
                "User-$employee->username: Thêm hợp đồng mới " . $contract->getContractId() .
                ". Khách hàng: $customer->fullname. Vào lúc: " . $createdAt->format('h:m A') .
                " Ngày: " . $createdAt->format('d-m-Y'),
            'created_at'    => $createdAt->format('Y-m-d'),
        ];
    }
}
