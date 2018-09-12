<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Role;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
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
        $role = Role::whereName($request->get('role'))->first();
        if ($role != NULL) {
            $data = $request->only(['name', 'username', 'email', 'company_id', 'activated']);
            Validator::make($data, [
                'name'          => 'required|min:4|max:255',
                'username'      => 'required|min:4|max:255|unique:users',
                'email'         => 'required|min:4|max:255|unique:users',
                'company_id'    => 'required|exists:companies,id',
                'activated'     => 'required'
            ])->validate();
            $data['password'] = bcrypt($request->get('password'));

            $employee = User::create($data);
            $employee->attachRole($role);

            return response()->json(['status' => 1, 'message' => 'Thêm thành công!', 'data' => $employee], 200);
        }
        return response()->json(['status' => 0, 'message' => 'Không thể thêm nhân viên vì không tìm thấy quyền!'], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) {
        $employee = User::findOrFail($id);
        $role = $employee->roles()->first();
        if ($role != NULL) {
            $employee->role = $role->name;
        }
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
        Validator::make($data, [
            'name'          => 'required|min:4|max:255',
            'username'      => 'required|min:4|max:255',
            'email'         => 'required|min:4|max:255',
            'company_id'    => 'required|exists:companies,id',
            'activated'     => 'required'
        ])->validate();

        if ($request->has('password') and $request->has('password') != NULL) {
            $data['password'] = bcrypt($request->get('password'));
        }

        $employee = User::findOrFail($id);
        $employee->update($data);

        if ($employee->hasRole($request->get('role')) == FALSE) {
            $role = Role::whereName($request->get('role'))->first();

            if ($role != NULL) {
                $employee->detachRoles();
                $employee->attachRole($role);
                return response()->json(['status' => 1, 'message' => 'Cập nhật nhân viên với quyền ' . $role->name . ' thành công!'], 200);
            }
            return response()->json(['status' => 0, 'message' => 'Không thể thêm nhân viên vì không tìm thấy quyền!'], 200);
        }
        return response()->json(['status' => 1, 'message' => 'Đã cập nhật nhân viên thành công!'], 200);
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
                'status'    => 0,
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
