<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Commodity extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'code',

        'mortgage_amount',
        'interest_before_mortgage',
        'interest_by_date',
        'total_interest',
        'interest_period',
        'days_of_delayed',
        'activated',

        'properties1',
        'properties2',
        'properties3',
        'properties4',
        'properties5',
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];
}
