<?php

namespace App\Http\Controllers;

use App\Models\Neighborhood;
use Illuminate\Http\Request;

class NeighborhoodController extends ResourceController
{
    public function __construct()
    {
        $this->model = Neighborhood::class;
    }

    public function get_neighborhoods_by_municipality(int $municipality_id)
    {
        $neighborhoods = Neighborhood::where('municipality_id', $municipality_id)->get();
        return response()->json($neighborhoods, 200);
    }
}
