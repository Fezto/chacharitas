<?php

namespace App\Http\Controllers;

use App\Models\Municipality;
use Illuminate\Http\Request;

class MunicipalityController extends ResourceController
{
    public function __construct()
    {
        $this->model = Municipality::class;
    }

    public function get_municipalities_by_state(int $state_id)
    {
        $municipalities = Municipality::where('state_id', $state_id)->get();
        return response()->json($municipalities, 200);
    }
}
