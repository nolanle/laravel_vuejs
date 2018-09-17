<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Contract extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'customer_id',
        'commodity_id',
        'commodity_name',
        'pawn_amount',
        'interest_before_pawn',
        'interest_by_date',
        'interest_period',
        'days_of_delayed',
        'pawn_date',
        'pawn_note',
        'attrs',
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    public function commodity() {
        return $this->belongsTo(Commodity::class, 'commodity_id', 'id');
    }

    public function customer() {
        return $this->belongsTo(Customer::class, 'customer_id', 'id');
    }

}
