<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

abstract class ResourceController extends Controller
{
    protected $model;

    public function index()
    {
        return $this->model::all();
    }

    public function show($id)
    {
        return $this->model::findOrFail($id);
    }

    public function store(Request $request)
    {
        return $this->model::create($request->all());
    }

    public function update(Request $request, $id)
    {
        $record = $this->model::findOrFail($id);
        $record->update($request->all());
        return $record;
    }

    public function destroy($id)
    {
        $record = $this->model::findOrFail($id);
        $record->delete();
        return response()->noContent();
    }
}
