<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Resources\TransactionsCollection;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AriseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $transactions = Transaction::orderBy('id', 'desc')->paginate(50);
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
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }
}
