<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Resources\ActivitiesCollection;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Spatie\Activitylog\Models\Activity;

class ActivityController extends Controller
{
    public function activities() {
        $activities = Activity::orderBy('id', 'desc')->paginate(50);
        $response = [
            'pagination' => [
                'total'         => $activities->total(),
                'per_page'      => $activities->perPage(),
                'current_page'  => $activities->currentPage(),
                'last_page'     => $activities->lastPage(),
                'from'          => $activities->firstItem(),
                'to'            => $activities->lastItem()
            ],
            'data' => new ActivitiesCollection($activities)
        ];
        return response()->json($response, 200);
    }
}
