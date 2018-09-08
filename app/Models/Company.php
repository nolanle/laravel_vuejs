<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Company extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name', 'phone', 'district_id', 'address', 'address_addition', 'represent', 'interested', 'total_investment', 'activated'
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];


    public function district() {
        return $this->belongsTo(District::class, 'district_id', 'id');
    }
}
