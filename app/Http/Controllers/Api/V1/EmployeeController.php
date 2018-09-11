<?php

namespace App\Http\Controllers\Api\V1;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $employees = User::paginate(25);
        return response()->json($employees, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        $data = $request->only(['name', 'username', 'email', 'company_id', 'activated']);
        $data['password'] = bcrypt($request->get('password'));

        $employee = User::create($data);
        return response()->json($employee, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) {
        $employee = User::findOrFail($id);
        return response()->json($employee, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {
        $data = $request->only(['name', 'username', 'email', 'company_id', 'activated']);
        if ($request->has('password') and $request->has('password') != NULL) {
            $data['password'] = bcrypt($request->get('password'));
        }

        $employee = User::findOrFail($id);
        $employee->update($data);

        return response()->json($employee, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {

        if (auth()->user()->id == $id) {
            return response()->json([
                'status'    =>0,
                'message'   => __('Bạn không thể xóa chính mình!'),
            ], 200);
        }

        $employee = User::findOrFail($id);
        $employee->delete();

        return response()->json([
            'status'    => 1,
            'message'   => __('Xóa nhân viên thành công!'),
        ], 200);
    }
}
