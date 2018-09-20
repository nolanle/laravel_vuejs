<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class HeaderCompanyResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request){
        return [
            'label'             => $this->name,
            'value'             => $this->id,

            'initial_capital'   => $this->getInitialCapital(),
            'current_balance'   => $this->getCurrentBalance(),

            'total_capital'     => $this->getTotalCapital(),
            'pawn_capital'      => $this->getPawnCapital(),
        ];
    }
}
