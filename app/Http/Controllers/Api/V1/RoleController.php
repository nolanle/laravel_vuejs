<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $roles = Role::paginate(25);
        return response()->json($roles, 200);
    }

    /**
     * Display a all listing of the companies.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexWithoutPaginate() {
        $roles = Role::all();
        return response()->json($roles, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        $data = $request->only(['display_name', 'description']);
        $data['name'] = str_slug($request->get('display_name'));

        Validator::make($data, [
            'name'          => 'required|min:4|unique:roles',
            'display_name'  => 'required|min:4|max:255',
        ])->validate();

        $role = Role::create($data);
        return response()->json($role, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) {
        $role = Role::findOrFail($id);
        return response()->json($role, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {
        $data = $request->only(['display_name', 'description']);

        Validator::make($data, [
            'display_name'  => 'required|min:4|max:255',
        ])->validate();

        $role = Role::findOrFail($id);
        $role->update($data);
        return response()->json($role, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        $role = Role::findOrFail($id);
        if ($role->users()->count() > 0) {
            return response()->json([
                'status'    => 0,
                'message'   => __('Không thể xóa do có nhân viên ủy thác!'),
            ], 200);
        }
        $role->delete();
        return response()->json([
            'status'    => 1,
            'message'   => __('Xóa phân quyền thành công!'),
        ], 200);

    }
}
