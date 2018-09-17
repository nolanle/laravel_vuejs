<?php

namespace App\Models;

use DateTime;
use Carbon\Carbon;
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
        'activated',
        'attrs',
        'histories',
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

    // CALCULATOR ######################################################################################################
    /**
     * Initialize for calculating
     */
    public function initialize() {
        $this->pawnDate      = Carbon::instance(new \DateTime($this->pawn_date));
        $this->redeemingDate = (clone $this->pawnDate)->addDays($this->interest_period - 1);
        $this->pawnDays      =
            Carbon::today() >= (clone $this->redeemingDate) ?
            $this->interest_period + (clone $this->redeemingDate)->diffInDays(Carbon::today()) :
            $this->interest_period - (clone $this->redeemingDate)->diffInDays(Carbon::today());
    }

    public function getPawnDays() {
        $this->initialize();
        return $this->pawnDays;
    }

    public function getPawnFeeAmount() {
        $this->initialize();
        return $this->interest_by_date * $this->pawnDays;
    }

    public function getRemainingDays() {
        $this->initialize();
        return $this->pawnDays >= $this->interest_period ? 0 : $this->redeemingDate->diffInDays(Carbon::today());
    }

    public function getPawnDate() {
        $this->initialize();
        return $this->pawnDate->format('Y-m-d');
    }

    public function getRemainingDate() {
        $this->initialize();
        return $this->redeemingDate->format('Y-m-d');
    }

//    public function liquidate() {
//        $histories = json_decode($this->histories);
//        $histories[] = [
//            'paid'      => true,
//            'amount'    => $this->getPawnFeeAmount(),
//            'pawn_days' => $this->getPawnDays(),
//            'paid_date' => Carbon::today()->format('Y-m-d'),
//        ];
//        $this->histories = json_encode($histories);
//        $this->is_liquidate = true;
//        $this->liquidate_date = Carbon::today();
//        $this->save();
//    }
//
//    public function paid() {
//        $histories = json_decode($this->histories);
//        $histories[] = [
//            'paid'      => true,
//            'amount'    => $this->getPawnFeeAmount(),
//            'pawn_days' => $this->getPawnDays(),
//            'paid_date' => Carbon::today()->format('Y-m-d'),
//        ];
//        $this->histories = json_encode($histories);
//        $this->save();
//    }
//
//    public function renew() {
//        $histories = json_decode($this->histories);
//        $histories[] = [
//            'type'            => 'liquidate',
//            'pawn_fee_amount' => $this->getPawnFeeAmount(),
//            'pawn_days'       => $this->getPawnDays(),
//            'created_at'      => Carbon::today()->format('Y-m-d'),
//        ];
//        $this->histories = json_encode($histories);
//        $this->is_liquidate = true;
//        $this->liquidate_date = Carbon::today();
//        $this->save();
//    }
    // CALCULATOR ######################################################################################################

}
