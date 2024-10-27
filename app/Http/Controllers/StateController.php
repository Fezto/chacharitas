<?php

namespace App\Http\Controllers;

use App\Models\State;
use Illuminate\Http\Request;

class StateController extends ResourceController
{
    public function __construct()
    {
        $this->model = State::class;
    }
}
