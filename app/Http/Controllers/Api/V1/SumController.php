<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Resources\SumsCollection;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SumController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $transactions = auth()->user()->company->sums()->orderBy('id', 'desc')->paginate(50);
        $response = [
            'pagination' => [
                'total'         => $transactions->total(),
                'per_page'      => $transactions->perPage(),
                'current_page'  => $transactions->currentPage(),
                'last_page'     => $transactions->lastPage(),
                'from'          => $transactions->firstItem(),
                'to'            => $transactions->lastItem()
            ],
            'data' => new SumsCollection($transactions),
        ];
        return response()->json($response, 200);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexWithFilter(Request $request) {
        $fromDate = Carbon::instance(new \DateTime($request->get('from_date')));
        $toDate = Carbon::instance(new \DateTime($request->get('to_date')));

        $transactions = auth()->user()->company->sums()
            ->whereBetween('arising_date', [$fromDate, $toDate])->orderBy('id', 'desc')
            ->paginate(50);

        $response = [
            'pagination' => [
                'total'         => $transactions->total(),
                'per_page'      => $transactions->perPage(),
                'current_page'  => $transactions->currentPage(),
                'last_page'     => $transactions->lastPage(),
                'from'          => $transactions->firstItem(),
                'to'            => $transactions->lastItem()
            ],
            'data' => new SumsCollection($transactions),
        ];
        return response()->json($response, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) {
    }

}
