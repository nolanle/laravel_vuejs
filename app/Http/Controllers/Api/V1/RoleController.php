<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Resources\RoleResource;
use App\Http\Resources\RolesCollection;
use App\Models\Permission;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use stdClass;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $roles = Role::paginate(25);
        $response = [
            'pagination' => [
                'total'         => $roles->total(),
                'per_page'      => $roles->perPage(),
                'current_page'  => $roles->currentPage(),
                'last_page'     => $roles->lastPage(),
                'from'          => $roles->firstItem(),
                'to'            => $roles->lastItem()
            ],
            'data' => new RolesCollection($roles)
        ];
        return response()->json($response, 200);
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
        $data['name'] = str_slug($request->get('display_name')) . '_' .time();

        Validator::make($data, [
            'name'          => 'required|min:4|unique:roles',
            'display_name'  => 'required|min:4|max:255',
        ])->validate();

        $role = Role::create($data);

        $permissions = $request->get('permissions');
        foreach ($permissions as $permission) {
            // check dashboard view
            if ($permission['value'] == 'dashboard' and $permission['selected'] == TRUE) {
                $permDB = Permission::whereName('dashboard')->first();
                $role->attachPermission($permDB);
            }

            if ($permission['value'] == 'all-company') {
                if ($permission['selected'] == TRUE) {
                    $index   = Permission::whereName('index-company')->first();
                    $create  = Permission::whereName('create-company')->first();
                    $edit    = Permission::whereName('edit-company')->first();
                    $delete  = Permission::whereName('delete-company')->first();
                    $role->attachPermissions([$index, $create, $edit, $delete]);
                }
                else {
                    foreach ($permission['children'] as $children) {
                        if ($children['value'] == 'index-company' and $children['selected'] == TRUE) {
                            $permDB = Permission::whereName('index-company')->first();
                            $role->attachPermission($permDB);
                        }

                        if ($children['value'] == 'create-company' and $children['selected'] == TRUE) {
                            $permDB = Permission::whereName('create-company')->first();
                            $role->attachPermission($permDB);
                        }

                        if ($children['value'] == 'edit-company' and $children['selected'] == TRUE) {
                            $permDB = Permission::whereName('edit-company')->first();
                            $role->attachPermission($permDB);
                        }

                        if ($children['value'] == 'delete-company' and $children['selected'] == TRUE) {
                            $permDB = Permission::whereName('delete-company')->first();
                            $role->attachPermission($permDB);
                        }
                    }
                }
            }

            if ($permission['value'] == 'all-commodity') {
                if ($permission['selected'] == TRUE) {
                    $index   = Permission::whereName('index-commodity')->first();
                    $create  = Permission::whereName('create-commodity')->first();
                    $edit    = Permission::whereName('edit-commodity')->first();
                    $delete  = Permission::whereName('delete-commodity')->first();
                    $role->attachPermissions([$index, $create, $edit, $delete]);
                }
                else {
                    foreach ($permission['children'] as $children) {
                        if ($children['value'] == 'index-commodity' and $children['selected'] == TRUE) {
                            $permDB = Permission::whereName('index-commodity')->first();
                            $role->attachPermission($permDB);
                        }

                        if ($children['value'] == 'create-commodity' and $children['selected'] == TRUE) {
                            $permDB = Permission::whereName('create-commodity')->first();
                            $role->attachPermission($permDB);
                        }

                        if ($children['value'] == 'edit-commodity' and $children['selected'] == TRUE) {
                            $permDB = Permission::whereName('edit-commodity')->first();
                            $role->attachPermission($permDB);
                        }

                        if ($children['value'] == 'delete-commodity' and $children['selected'] == TRUE) {
                            $permDB = Permission::whereName('delete-commodity')->first();
                            $role->attachPermission($permDB);
                        }
                    }
                }
            }

            if ($permission['value'] == 'all-role') {
                if ($permission['selected'] == TRUE) {
                    $index   = Permission::whereName('index-role')->first();
                    $create  = Permission::whereName('create-role')->first();
                    $edit    = Permission::whereName('edit-role')->first();
                    $delete  = Permission::whereName('delete-role')->first();
                    $role->attachPermissions([$index, $create, $edit, $delete]);
                }
                else {
                    foreach ($permission['children'] as $children) {
                        if ($children['value'] == 'index-role' and $children['selected'] == TRUE) {
                            $permDB = Permission::whereName('index-role')->first();
                            $role->attachPermission($permDB);
                        }

                        if ($children['value'] == 'create-role' and $children['selected'] == TRUE) {
                            $permDB = Permission::whereName('create-role')->first();
                            $role->attachPermission($permDB);
                        }

                        if ($children['value'] == 'edit-role' and $children['selected'] == TRUE) {
                            $permDB = Permission::whereName('edit-role')->first();
                            $role->attachPermission($permDB);
                        }

                        if ($children['value'] == 'delete-role' and $children['selected'] == TRUE) {
                            $permDB = Permission::whereName('delete-role')->first();
                            $role->attachPermission($permDB);
                        }
                    }
                }
            }

            if ($permission['value'] == 'all-employee') {
                if ($permission['selected'] == TRUE) {
                    $index   = Permission::whereName('index-employee')->first();
                    $create  = Permission::whereName('create-employee')->first();
                    $edit    = Permission::whereName('edit-employee')->first();
                    $delete  = Permission::whereName('delete-employee')->first();
                    $role->attachPermissions([$index, $create, $edit, $delete]);
                }
                else {
                    foreach ($permission['children'] as $children) {
                        if ($children['value'] == 'index-employee' and $children['selected'] == TRUE) {
                            $permDB = Permission::whereName('index-employee')->first();
                            $role->attachPermission($permDB);
                        }

                        if ($children['value'] == 'create-employee' and $children['selected'] == TRUE) {
                            $permDB = Permission::whereName('create-employee')->first();
                            $role->attachPermission($permDB);
                        }

                        if ($children['value'] == 'edit-employee' and $children['selected'] == TRUE) {
                            $permDB = Permission::whereName('edit-employee')->first();
                            $role->attachPermission($permDB);
                        }

                        if ($children['value'] == 'delete-employee' and $children['selected'] == TRUE) {
                            $permDB = Permission::whereName('delete-employee')->first();
                            $role->attachPermission($permDB);
                        }
                    }
                }
            }

            if ($permission['value'] == 'all-customer') {
                if ($permission['selected'] == TRUE) {
                    $index   = Permission::whereName('index-customer')->first();
                    $create  = Permission::whereName('create-customer')->first();
                    $edit    = Permission::whereName('edit-customer')->first();
                    $delete  = Permission::whereName('delete-customer')->first();
                    $role->attachPermissions([$index, $create, $edit, $delete]);
                }
                else {
                    foreach ($permission['children'] as $children) {
                        if ($children['value'] == 'index-customer' and $children['selected'] == TRUE) {
                            $permDB = Permission::whereName('index-customer')->first();
                            $role->attachPermission($permDB);
                        }

                        if ($children['value'] == 'create-customer' and $children['selected'] == TRUE) {
                            $permDB = Permission::whereName('create-customer')->first();
                            $role->attachPermission($permDB);
                        }

                        if ($children['value'] == 'edit-customer' and $children['selected'] == TRUE) {
                            $permDB = Permission::whereName('edit-customer')->first();
                            $role->attachPermission($permDB);
                        }

                        if ($children['value'] == 'delete-customer' and $children['selected'] == TRUE) {
                            $permDB = Permission::whereName('delete-customer')->first();
                            $role->attachPermission($permDB);
                        }
                    }
                }
            }

            if ($permission['value'] == 'all-contract') {
                if ($permission['selected'] == TRUE) {
                    $index      = Permission::whereName('index-contract')->first();
                    $warning    = Permission::whereName('warning-contract')->first();
                    $create     = Permission::whereName('create-contract')->first();
                    $edit       = Permission::whereName('edit-contract')->first();
                    $paid       = Permission::whereName('paid-contract')->first();
                    $renew      = Permission::whereName('renew-contract')->first();
                    $liquidate  = Permission::whereName('liquidate-contract')->first();
                    $delete     = Permission::whereName('delete-contract')->first();
                    $role->attachPermissions([$index, $warning, $create, $edit, $paid, $renew, $liquidate, $delete]);
                }
                else {
                    foreach ($permission['children'] as $children) {
                        if ($children['value'] == 'index-contract' and $children['selected'] == TRUE) {
                            $permDB = Permission::whereName('index-contract')->first();
                            $role->attachPermission($permDB);
                        }

                        if ($children['value'] == 'warning-contract' and $children['selected'] == TRUE) {
                            $permDB = Permission::whereName('warning-contract')->first();
                            $role->attachPermission($permDB);
                        }

                        if ($children['value'] == 'create-contract' and $children['selected'] == TRUE) {
                            $permDB = Permission::whereName('create-contract')->first();
                            $role->attachPermission($permDB);
                        }

                        if ($children['value'] == 'edit-contract' and $children['selected'] == TRUE) {
                            $permDB = Permission::whereName('edit-contract')->first();
                            $role->attachPermission($permDB);
                        }

                        if ($children['value'] == 'paid-contract' and $children['selected'] == TRUE) {
                            $permDB = Permission::whereName('paid-contract')->first();
                            $role->attachPermission($permDB);
                        }

                        if ($children['value'] == 'renew-contract' and $children['selected'] == TRUE) {
                            $permDB = Permission::whereName('renew-contract')->first();
                            $role->attachPermission($permDB);
                        }

                        if ($children['value'] == 'liquidate-contract' and $children['selected'] == TRUE) {
                            $permDB = Permission::whereName('liquidate-contract')->first();
                            $role->attachPermission($permDB);
                        }

                        if ($children['value'] == 'delete-contract' and $children['selected'] == TRUE) {
                            $permDB = Permission::whereName('delete-contract')->first();
                            $role->attachPermission($permDB);
                        }
                    }
                }
            }

            if ($permission['value'] == 'all-utils') {
                if ($permission['selected'] == TRUE) {
                    $change   = Permission::whereName('change-company-account')->first();
                    $role->attachPermissions([$change]);
                }
                else {
                    foreach ($permission['children'] as $children) {
                        if ($children['value'] == 'change-company-account' and $children['selected'] == TRUE) {
                            $permDB = Permission::whereName('change-company-account')->first();
                            $role->attachPermission($permDB);
                        }
                    }
                }
            }

        }
        return response()->json($permissions, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) {
        $role = Role::findOrFail($id);
        return response()->json(new RoleResource($role), 200);
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
