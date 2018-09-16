<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Company;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class AccountController extends Controller
{
    public function activities() {
        $activities = auth()->user()->activities()->orderBy('id', 'desc')->take(25)->get();
        return response()->json($activities, 200);
    }

    public function changeCompany(Request $request) {
        Validator::make($request->all(), [
            'id' => 'required|exists:companies,id',
        ])->validate();

        if (auth()->user()->company_id != $request->get('id')) {

            auth()->user()->company_id = $request->get('id');
            auth()->user()->save();

            return response()->json(['done' => true], 200);
        }
        return response()->json(['done' => false], 200);
    }

}
