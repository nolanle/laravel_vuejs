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
    public $outOfDate       = false;
    public $outOfDateDays   = 0;

    /**
     * Get contract by ID to contract ID format
     *
     * @return string
     */
    public function getContractId() {
        $result = "HDCD";
        if (strlen((string)$this->id) < 5)
            for ($i = 0; $i < 5 - strlen((string)$this->id); $i++)
                $result .= '0';
        return $result .= $this->id;
    }

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

        // create transaction for contract
        $transaction = Transaction::create([
            'type'          => 'pawning',
            'addition'      => FALSE,
            'contract_id'   => $this->id,
            'company_id'    => $this->company_id,
            'amount'        => $this->pawn_amount,
        ]);
        $sum = Sum::where('company_id', $this->company_id)->where('arising_date', Carbon::today()->format('Y-m-d'))->first();
        if ($sum == NULL) {
            $sum = Sum::create([
                'company_id'            => $this->company_id,
                'beginning_balance'     => $this->company->getCurrentBalance(),
                'arising_date'          => Carbon::today(),
            ]);
        }
        $sum->total_cost        += $transaction->amount;
        $sum->ending_balance    = $sum->beginning_balance + $sum->total_revenue - $sum->total_cost;
        $sum->save();

        if ($this->interest_before_pawn and $this->paid_date == NULL) {
            $histories = json_decode($this->histories);
            $histories[] = [
                'amount'    => $this->interest_by_date * $this->interest_period,
                'from'      => $this->pawn_date,
                'to'        => $this->pawn_date,
                'paid_days' => $this->interest_period,
                'paid'      => TRUE,
            ];
            $this->histories = json_encode($histories);
            $this->paid_date = $this->pawn_date;
            $this->save();

            // revenue for contract with interest before pawn
            $transaction = Transaction::create([
                'type'          => 'paid_fee',
                'addition'      => TRUE,
                'contract_id'   => $this->id,
                'company_id'    => $this->company_id,
                'amount'        => $this->interest_by_date * $this->interest_period,
            ]);
            $sum = Sum::where('company_id', $this->company_id)->where('arising_date', Carbon::today()->format('Y-m-d'))->first();
            if ($sum == NULL) {
                $sum = Sum::create([
                    'company_id'            => $this->company_id,
                    'beginning_balance'     => $this->company->getCurrentBalance(),
                    'arising_date'          => Carbon::today(),
                ]);
            }
            $sum->total_revenue     += $transaction->amount;
            $sum->ending_balance    = $sum->beginning_balance + $sum->total_revenue - $sum->total_cost;
            $sum->save();

        }
    }

    public function getNextPaid() {
        if ($this->liquidate_date == NULL) {
            $this->initialize();
            $latestDate = '';
            $histories = json_decode($this->histories);
            if ($histories != NULL) {
                foreach ($histories as $history) {
                    $latestDate = Carbon::instance(new \DateTime($history->to))->addDay();
                }
            }
            return [
                'amount'    => $this->interest_by_date * $this->interest_period,
                'from'      => $latestDate != NULL ? $latestDate->format('Y-m-d') : $this->pawnDate->format('Y-m-d'),
                'to'        => $latestDate != NULL ? 
                            (clone $latestDate)->addDays($this->interest_period)->format('Y-m-d') : 
                            (clone $this->pawnDate)->addDays($this->interest_period)->format('Y-m-d'),

                'paid_days' => $this->interest_period,
                'paid'      => FALSE,
            ];
        }
        return NULL;
    }

    public function paid($history) {
        $latestDate = '';
        $histories = json_decode($this->histories);
        if ($histories != NULL) {
            foreach ($histories as $item) {
                $latestDate = Carbon::instance(new \DateTime($item->to))->addDay();
            }
        }
        if (Carbon::instance(new \DateTime($history['from'])) >= $latestDate) {
            $history['paid'] = TRUE;
            $histories = json_decode($this->histories);
            $histories[] = $history;
            $this->histories = json_encode($histories);
            $this->paid_date = Carbon::today();
            $this->save();
            $transaction = Transaction::create([ // revenue for contract with interest before pawn
                'type'          => 'paid_fee',
                'addition'      => TRUE,
                'contract_id'   => $this->id,
                'company_id'    => $this->company_id,
                'amount'        => $this->interest_by_date * $this->interest_period,
            ]);
            $sum = Sum::where('company_id', $this->company_id)->where('arising_date', Carbon::today()->format('Y-m-d'))->first();
            if ($sum == NULL) {
                $sum = Sum::create([
                    'company_id'            => $this->company_id,
                    'beginning_balance'     => $this->company->getCurrentBalance(),
                    'arising_date'          => Carbon::today(),
                ]);
            }
            $sum->total_revenue     += $transaction->amount;
            $sum->ending_balance    = $sum->beginning_balance + $sum->total_revenue - $sum->total_cost;
            $sum->save();
            return TRUE;
        }
        return FALSE;
    }

    public function unPaid($history) {
        $histories = json_decode($this->histories);
        $result = [];
        if ($histories != NULL) {
            foreach ($histories as $item) {
                if ($item->from == $history['from'] and $item->to == $history['to']) {
                } else {
                    $result[] = $item;
                }
            }
        }

        $historyForRemove = end($histories);
        if ($historyForRemove != NULL and $historyForRemove->from == $history['from'] and $historyForRemove->to == $history['to']) {
            $this->histories = json_encode($result);
            $this->save();
            return TRUE;
        }
        return FALSE;
    }

    public function liquidate() {
        $this->liquidate_date = Carbon::today();
        $this->save();

        // revenue for contract with interest before pawn
        $transaction = Transaction::create([
            'type'          => 'liquidate',
            'addition'      => TRUE,
            'contract_id'   => $this->id,
            'company_id'    => $this->company_id,
            'amount'        => $this->pawn_amount,
        ]);
        $sum = Sum::where('company_id', $this->company_id)->where('arising_date', Carbon::today()->format('Y-m-d'))->first();
        if ($sum == NULL) {
            $sum = Sum::create([
                'company_id'            => $this->company_id,
                'beginning_balance'     => $this->company->getCurrentBalance(),
                'arising_date'          => Carbon::today(),
            ]);
        }
        $sum->total_revenue     += $transaction->amount;
        $sum->ending_balance    = $sum->beginning_balance + $sum->total_revenue - $sum->total_cost;
        $sum->save();
    }

    public function refund() {
        // revenue for contract with interest before pawn
        $transaction = Transaction::create([
            'type'          => 'refund',
            'addition'      => TRUE,
            'contract_id'   => $this->id,
            'company_id'    => $this->company_id,
            'amount'        => $this->pawn_amount,
        ]);
        $sum = Sum::where('company_id', $this->company_id)->where('arising_date', Carbon::today()->format('Y-m-d'))->first();
        if ($sum == NULL) {
            $sum = Sum::create([
                'company_id'            => $this->company_id,
                'beginning_balance'     => $this->company->getCurrentBalance(),
                'arising_date'          => Carbon::today(),
            ]);
        }
        $sum->total_revenue     += $transaction->amount;
        $sum->ending_balance    = $sum->beginning_balance + $sum->total_revenue - $sum->total_cost;
        $sum->save();
    }

    /**
     * Initialize for calculating
     */
    public function initialize() {
        $this->pawnDate      = Carbon::instance(new \DateTime($this->pawn_date))->addDay();
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
