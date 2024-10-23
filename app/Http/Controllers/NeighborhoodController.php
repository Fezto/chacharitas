<?php

namespace App\Http\Controllers;

use App\Models\Neighborhood;
use Illuminate\Http\Request;

class NeighborhoodController extends BaseController
{
    public function __construct()
    {
        $this->model = Neighborhood::class;
    }
}
