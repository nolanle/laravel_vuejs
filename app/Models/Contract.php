<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Contract extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'customer_id', 'commodity_id', 'company_id', 'commodity_name',
        'pawn_amount', 'interest_before_pawn', 'interest_by_date',
        'interest_period', 'days_of_delayed', 'pawn_date',
        'pawn_note', 'activated', 'attrs', 'histories',
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    public $pawnDate;
    public $pawnDays;
    public $redeemingDate;
    public $outOfDate = false;
    public $outOfDateDays = 0;

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function commodity() {
        return $this->belongsTo(Commodity::class, 'commodity_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function customer() {
        return $this->belongsTo(Customer::class, 'customer_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function company() {
        return $this->belongsTo(Company::class, 'company_id', 'id');
    }

    // CALCULATOR ######################################################################################################
    public function interestBeforePawn() {
        if ($this->interest_before_pawn and $this->paid_date == NULL) {
            $histories = json_decode($this->histories);
            $histories[] = [
                'amount'    => $this->interest_by_date * $this->interest_period,
                'from'      => $this->pawn_date,
                'to'        => $this->pawn_date,
                'paid_days' => $this->interest_period,
            ];
            $this->histories = json_encode($histories);
            $this->paid_date = $this->pawn_date;
            $this->save();
        }
    }

    public function paid() {
        $this->initialize();

        $histories = json_decode($this->histories);
        $histories[] = [
            'amount'    => $this->interest_by_date * $this->interest_period,
            'from'      => $this->renew_date ?? $this->pawn_date,
            'to'        => $this->redeemingDate->format('Y-m-d'),
            'paid_days' => $this->interest_period,
        ];
        $this->histories = json_encode($histories);

        $this->paid_date = Carbon::today();
        $this->save();
    }

    public function liquidate() {
        $this->liquidate_date = Carbon::today();
        $this->save();
    }

    /**
     * Initialize for calculating
     */
    public function initialize() {
        $this->pawnDate      = Carbon::instance(new \DateTime($this->pawn_date));
        $this->redeemingDate = (clone $this->pawnDate)->addDays($this->interest_period);

        $this->pawnDays      = Carbon::today() >= (clone $this->redeemingDate) ?
            $this->interest_period + (clone $this->redeemingDate)->diffInDays(Carbon::today()) :
            $this->interest_period - (clone $this->redeemingDate)->diffInDays(Carbon::today());

        $maxDays = $this->interest_period; // + $this->days_of_delayed;
        if ($this->pawnDays > $maxDays) {
            $this->outOfDate = true;
            $this->outOfDateDays = $this->pawnDays - $maxDays;
            // $this->outOfDateDays = $this->pawnDays - $maxDays > $this->days_of_delayed ? $this->days_of_delayed : $this->pawnDays - $maxDays;
            $this->pawnDays = $maxDays;
        }
    }

    /**
     * @return bool
     */
    public function getOutOfDate() {
        $this->initialize();
        return $this->outOfDate;
    }

    /**
     * @return int
     */
    public function getOutOfDateDays() {
        $this->initialize();
        return $this->outOfDateDays;
    }

    /**
     * @return mixed
     */
    public function getPawnDays() {
        $this->initialize();
        return $this->pawnDays;
    }

    /**
     * @return float|int
     */
    public function getPawnFeeAmount() {
        $this->initialize();
        return $this->interest_by_date * $this->pawnDays;
    }

    /**
     * @return int
     */
    public function getRemainingDays() {
        $this->initialize();
        return $this->pawnDays >= $this->interest_period ? 0 : $this->redeemingDate->diffInDays(Carbon::today());
    }

    /**
     * @return mixed
     */
    public function getPawnDate() {
        $this->initialize();
        return $this->pawnDate->format('Y-m-d');
    }

    /**
     * @return mixed
     */
    public function getRemainingDate() {
        $this->initialize();
        return $this->redeemingDate->format('Y-m-d');
    }
    // CALCULATOR ######################################################################################################
}
