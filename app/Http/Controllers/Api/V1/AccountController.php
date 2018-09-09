<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AccountController extends Controller
{
    public function activities() {
        $activities = auth()->user()->activities()->orderBy('id', 'desc')->take(25)->get();
        return response()->json($activities, 200);
    }
}
