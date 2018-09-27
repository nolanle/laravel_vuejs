<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Resources\TransactionResource;
use App\Http\Resources\TransactionsCollection;
use App\Models\Company;
use App\Models\Sum;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class AriseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $transactions = auth()->user()->company->transactions()->orderBy('id', 'desc')->paginate(50);
        $response = [
            'pagination' => [
                'total'         => $transactions->total(),
                'per_page'      => $transactions->perPage(),
                'current_page'  => $transactions->currentPage(),
                'last_page'     => $transactions->lastPage(),
                'from'          => $transactions->firstItem(),
                'to'            => $transactions->lastItem()
            ],
            'data' => new TransactionsCollection($transactions)
        ];
        return response()->json($response, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        $data = $request->only(['amount', 'company_id', 'created_at', 'description', 'type']);
        Validator::make($data, [
            'company_id'    => 'required|exists:companies,id',
            'amount'        => 'required|integer|min:1',
            'type'          => 'required|string|min:3|max:255',
            'created_at'    => 'required|date',
        ])->validate();

        $sum = Sum::where('company_id', $data['company_id'])->where('arising_date', Carbon::today()->format('Y-m-d'))->first();
        if ($sum == NULL) {
            $sum = Sum::create([
                'company_id'            => $data['company_id'],
                'beginning_balance'     => Company::findOrFail($data['company_id'])->getCurrentBalance(),
                'arising_date'          => Carbon::today(),
            ]);
        }

        try {
            if ($data['type'] == "deposit_other") {
                $data['type']       = 'other';
                $data['addition']   = TRUE;
                $sum->total_revenue += $data['amount'];
            }
            elseif ($data['type'] == "withdraw_other") {
                $data['type']       = 'other';
                $data['addition']   = FALSE;
                $sum->total_cost    += $data['amount'];
            }
            elseif ($data['type'] == 'withdraw') {
                $data['addition']   = FALSE;
                $sum->total_cost    += $data['amount'];
            }
            else {
                $sum->total_revenue += $data['amount'];
            }
            $sum->ending_balance = $sum->beginning_balance + $sum->total_revenue - $sum->total_cost;
            $sum->save();

            $transaction = Transaction::create($data);
            return response()->json(['done' => true, 'data' => $transaction], 200);
        }
        catch (\Exception $exception) {
            return response()->json(['done' => false], 200);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) {
        $transaction = Transaction::findOrFail($id);
        return response()->json(new TransactionResource($transaction), 200);
    }
}
