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

    /**
     * Get Contracts of Company
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function contracts() {
        return $this->hasMany(Contract::class, 'company_id', 'id');
    }

    /**
     * Get Transactions of this company
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function transactions() {
        return $this->hasMany(Transaction::class, 'company_id', 'id');
    }

    public function getInitialCapital() {
        $totalInitialCapital = 0;
        foreach ($this->transactions as $transaction) {
            if ($transaction->type == 'initial' and $transaction->addition) {
                $totalInitialCapital += $transaction->amount;
            }
        }
        return $totalInitialCapital;
    }

    public function getCurrentBalance() {
        $totalInitialCapital = 0;
        foreach ($this->transactions as $transaction) {
            if ($transaction->addition) {
                $totalInitialCapital += $transaction->amount;
            } else {
                $totalInitialCapital -= $transaction->amount;
            }
        }
        return $totalInitialCapital;
    }

}
