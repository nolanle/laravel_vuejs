<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Resources\ContractResource;
use App\Http\Resources\ContractsCollection;
use App\Models\Contract;
use App\Models\Customer;
use Carbon\Carbon;
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
        $contracts = auth()->user()->company->contracts()->paginate(25);
        $response = [
            'pagination' => [
                'total'         => $contracts->total(),
                'per_page'      => $contracts->perPage(),
                'current_page'  => $contracts->currentPage(),
                'last_page'     => $contracts->lastPage(),
                'from'          => $contracts->firstItem(),
                'to'            => $contracts->lastItem()
            ],
            'data' => new ContractsCollection($contracts)
        ];
        return response()->json($response, 200);
    }

    public function paid($id) {
        $contract = Contract::findOrFail($id);
        $contract->paid();
        return response()->json($contract, 200);
    }

    public function liquidate($id) {
        $contract = Contract::findOrFail($id);
        $contract->liquidate();
        return response()->json($contract, 200);
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
            'pawn_amount'           => 'required|integer|min:1',
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

            // Create new contract
            $newCustomer = Customer::create($customerData);
            $data['customer_id'] = $newCustomer->id;
        }

        // Create new contract
        $data['company_id'] = auth()->user()->company_id;
        $newContract = Contract::create($data);
        $newContract->interestBeforePawn();

        // Update additional attributes from commodity
        if ($request->get('attrs') != NULL) {
            $newContract->attrs = json_encode($request->get('attrs'));
            $newContract->save();
        }

        // return with response
        return response()->json($newContract, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) {
        $contract = Contract::findOrFail($id);
        return response()->json(new ContractResource($contract), 200);
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
            'pawn_amount'           => 'required|integer|min:1',
            'interest_before_pawn'  => 'required|boolean',
            'interest_by_date'      => 'required|integer|min:1',
            'interest_period'       => 'required|integer|min:1',
            'days_of_delayed'       => 'required|integer|min:1',
            'pawn_date'             => 'required|date',
        ])->validate();

        // update contract informations
        $data['attrs'] = json_encode($request->get('attrs'));
        $contract->update($data);
        $contract->interestBeforePawn();

        $data = $request->get('customer');
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
    public function destroy($id) {
        $contract = Contract::findOrFail($id);
        $contract->delete();
        return response()->json([
            'status'    => 1,
            'message'   => __('Xóa hợp đồng thành công'),
        ], 200);
    }
}
