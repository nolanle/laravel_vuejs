<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Company;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $companies = Company::paginate(25);
        return response()->json($companies, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        $company = Company::create(
            $request->only([
                'name', 'phone', 'district_id', 'address', 'represent', 'interested', 'activated'
            ])
        );
        $company->total_investment = $request->get('interested');
        $company->save();

        return response()->json($company, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) {
        $company = Company::findOrFail($id);
        $company->province_id = $company->district->province_id;
        return response()->json($company, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {
        $company = Company::findOrFail($id);
        $company->update($request->only([
            'name', 'phone', 'district_id', 'address', 'represent', 'interested', 'activated'
        ]));
        return response()->json($company, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        $company = Company::findOrFail($id);
        $company->delete();
        return response()->json([
            'status'    => 1,
            'message'   => __('Xóa công ty thành công'),
        ], 200);
    }
}
