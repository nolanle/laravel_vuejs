<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Sum extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'beginning_balance', 'ending_balance', 'total_revenue', 'total_cost', 'arising_date', 'company_id',
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];


    /**
     * Get company of sum
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function company() {
        return $this->belongsTo(Company::class, 'company_id', 'id');
    }

}
