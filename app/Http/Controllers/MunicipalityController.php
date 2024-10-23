<?php

namespace App\Http\Controllers;

use App\Models\Municipality;
use Illuminate\Http\Request;

class MunicipalityController extends BaseController
{
    public function __construct()
    {
        $this->model = Municipality::class;
    }
}
