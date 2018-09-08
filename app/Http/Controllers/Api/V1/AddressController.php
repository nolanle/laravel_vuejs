<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Province;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AddressController extends Controller
{
    public function provinces() {
        $provinces = Province::all();
        return response()->json($provinces, 200);
    }

    public function province($id) {
        $province = Province::findOrFail($id);
        return response()->json($province->districts, 200);
    }
}
