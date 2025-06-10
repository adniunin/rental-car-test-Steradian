<?php

namespace App\Http\Controllers;

use App\Models\cars;
use Illuminate\Http\Request;

class CarsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        return cars::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $data = $request->validate([
            'car_name' => 'required|string',
            'day_rate' => 'required|numeric',
            'month_rate' => 'required|numeric',
            'image' => 'required|string',
        ]);

        return cars::create($data);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        //
        $cars = cars::find($id);
        return $cars;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        //
        $data = $request->validate([
            'car_name' => 'required|string',
            'day_rate' => 'required|numeric',
            'month_rate' => 'required|numeric',
            'image' => 'required|string',
        ]);
        $cars = cars::find($id);
        $cars->update($data);
        return response()->json([
            'message' => 'Car Updated',
            'data' => $cars
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $cars = cars::find($id);
        $cars->delete();
        return response()->json([
            'message' => 'Car Deleted',
            'data' => $cars
        ]);
    }
}
