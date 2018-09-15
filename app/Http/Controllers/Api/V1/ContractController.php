<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Contract;
use App\Models\Customer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class ContractController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $contracts = Contract::orderBy('created_at', 'desc')->paginate(25);
        return response()->json($contracts, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        $data = $request->only([
            'commodity_id',
            'commodity_name', 'pawn_amount', 'interest_before_pawn',
            'interest_by_date', 'interest_period', 'days_of_delayed',
            'pawn_date', 'pawn_note'
        ]);

        Validator::make($data, [
            'commodity_id'          => 'required|exists:commodities,id',
            'commodity_name'        => 'required|string|min:6|max:255',
            'pawn_amount'           => 'required|integer|min:0',
            'interest_before_pawn'  => 'required|boolean',
            'interest_by_date'      => 'required|integer|min:1',
            'interest_period'       => 'required|integer|min:1',
            'days_of_delayed'       => 'required|integer|min:1',
            'pawn_date'             => 'required|date',
        ])->validate();

        $validate = [
            'type'          => 'required|string|min:3|max:6',
            'fullname'      => 'required|string|min:6|max:255',
            'address'       => 'required|string|min:6|max:255',
            'phone'         => 'required|string|min:10|max:12',
            'government_id' => 'required|string|min:9|max:15',
            'issued_at'     => 'required|string|min:4|max:50',
            'issued_date'   => 'required|date',
        ];
        $customerData = (array)$request->get('customer');
        if ($customerData['type'] == 'old') {
            $validate['id'] = 'required|exists:customers,id';
            Validator::make($customerData, $validate)->validate();

            // cập nhật thông tin khách hàng cũ
            $data['customer_id'] = $customerData['id'];
        }
        else {
            Validator::make($customerData, $validate)->validate();
            $customerData['company_id']     = auth()->user()->company_id;
            $customerData['activated']      = TRUE;

            // Tạo khách hàng mới
            $newCustomer = Customer::create($customerData);
            $data['customer_id'] = $newCustomer->id;
        }

        // Tạo hợp đồng mới
        $newContract = Contract::create($data);
        return response()->json($customerData, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) {
        $contract = Contract::findOrFail($id);
        $contract->commodity;
        $contract->customer;
        return response()->json($contract, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {
        $contract = Contract::findOrFail($id);
        $data = $request->only([
            'commodity_id',
            'commodity_name',
            'pawn_amount',
            'interest_before_pawn',
            'interest_by_date',
            'interest_period',
            'days_of_delayed',
            'pawn_date',
            'pawn_note'
        ]);
        Validator::make($data, [
            'commodity_id'          => 'required|exists:commodities,id',
            'commodity_name'        => 'required|string|min:6|max:255',
            'pawn_amount'           => 'required|integer|min:0',
            'interest_before_pawn'  => 'required|boolean',
            'interest_by_date'      => 'required|integer|min:1',
            'interest_period'       => 'required|integer|min:1',
            'days_of_delayed'       => 'required|integer|min:1',
            'pawn_date'             => 'required|date',
        ])->validate();

        // update contract informations
        $contract->update($data);

        $data = $request->get('customer'); // unset($data['id']);unset($data['activated']);unset($data['company_id']);unset($data['created_at']);unset($data['updated_at']);unset($data['deleted_at']);
        Validator::make($data, [
            'fullname'      => 'required|string|min:6|max:255',
            'address'       => 'required|string|min:6|max:255',
            'phone'         => 'required|string|min:10|max:12',
            'government_id' => 'required|string|min:9|max:15',
            'issued_at'     => 'required|string|min:4|max:50',
            'issued_date'   => 'required|date',
        ])->validate();
        $customer = $contract->customer;

        // update customer informations
        $customer->update($data);
        return response()->json($contract, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
