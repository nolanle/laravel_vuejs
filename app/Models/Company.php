<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Company extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name', 'phone', 'district_id', 'address', 'address_addition', 'represent', 'activated'
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    /**
     * Get District of Company
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function district() {
        return $this->belongsTo(District::class, 'district_id', 'id');
    }
}
