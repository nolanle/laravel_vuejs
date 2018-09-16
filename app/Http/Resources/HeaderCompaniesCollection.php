<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class HeaderCompaniesCollection extends ResourceCollection
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
            $result[] = new HeaderCompanyResource($item);
        }
        return $result;
    }
}
