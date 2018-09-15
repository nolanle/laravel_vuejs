<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Customer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $customers = Customer::paginate(25);
        return response()->json($customers, 200);
    }

    /**
     * Display a listing of the resource by searching.
     *
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request) {
        $text = $request->get('text') ?? '';
        $customers = Customer::where('fullname', 'LIKE', '%' . $text . '%')->take(10)->get();
        return response()->json($customers, 200);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexWithoutPaginate() {
        $customers = Customer::all();
        return response()->json($customers, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        $customer = Customer::create(
            $request->only([
                'fullname', 'address', 'phone', 'government_id', 'activated', 'company_id'
            ])
        );
        return response()->json($customer, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) {
        $customer = Customer::findOrFail($id);
        return response()->json($customer, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {
        $customer = Customer::findOrFail($id);
        $customer->update($request->only([
            'fullname', 'address', 'phone', 'government_id', 'activated', 'company_id'
        ]));
        return response()->json($customer, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        $customer = Customer::findOrFail($id);
        $customer->delete();
        return response()->json([
            'status'    => 1,
            'message'   => __('Xóa khách hàng thành công'),
        ], 200);
    }
}
