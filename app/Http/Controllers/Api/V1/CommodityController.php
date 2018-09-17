<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Resources\CommoditiesCollection;
use App\Http\Resources\CommodityResource;
use App\Models\Commodity;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CommodityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $commodities = Commodity::paginate(25);
        $response = [
            'pagination' => [
                'total'         => $commodities->total(),
                'per_page'      => $commodities->perPage(),
                'current_page'  => $commodities->currentPage(),
                'last_page'     => $commodities->lastPage(),
                'from'          => $commodities->firstItem(),
                'to'            => $commodities->lastItem()
            ],
            'data' => new CommoditiesCollection($commodities)
        ];
        return response()->json($response, 200);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexWithoutPaginate() {
        $commodities = Commodity::all();
        return response()->json(new CommoditiesCollection($commodities), 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        $commodity = Commodity::create(
            $request->only([
                'name',
                'code',
                'mortgage_amount',
                'interest_before_mortgage',
                'interest_by_date',
                'total_interest',
                'interest_period',
                'days_of_delayed',
                'activated',
            ])
        );

        if ($request->get('attrs') != NULL) {
            // update attrs
            $attrs = [];
            foreach ($request->get('attrs') as $item) {
                $attrs[] = $item['key'];
            }
            $commodity->attrs = json_encode($attrs);
            $commodity->save();
        }

        return response()->json($commodity, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) {
        $commodity = Commodity::findOrFail($id);
        return response()->json(new CommodityResource($commodity), 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {
        $commodity = Commodity::findOrFail($id);
        $commodity->update($request->only([
            'name', 'code',
            'mortgage_amount',
            'interest_before_mortgage',
            'interest_by_date',
            'total_interest',
            'interest_period',
            'days_of_delayed',
            'activated',
        ]));

        if ($request->get('attrs') != NULL) {
            // update attrs
            $attrs = [];
            foreach ($request->get('attrs') as $item) {
                $attrs[] = $item['key'];
            }
            $commodity->attrs = json_encode($attrs);
            $commodity->save();
        }
        return response()->json($commodity, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        $commodity = Commodity::findOrFail($id);
        $commodity->delete();
        return response()->json([
            'status'    => 1,
            'message'   => __('Xóa hàng hóa thành công'),
        ], 200);
    }
}
