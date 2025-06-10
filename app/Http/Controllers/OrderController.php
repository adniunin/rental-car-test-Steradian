<?php

namespace App\Http\Controllers;

use App\Models\cars;
use App\Models\orders;
use Illuminate\Http\Request;
use Carbon\Carbon;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return orders::all();
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $data = $request->validate([
            'car_id' => 'required',
            'order_date' => 'required',
            'pickup_date' => 'required',
            'dropoff_date' => 'required',
            'pickup_location' => 'required',
            'dropoff_location' => 'required',
        ]);
        
        $search = orders::selectRaw('DATE(dropoff_date) as date')
            ->where('car_id', $request->car_id)
            ->orderBy('id', 'DESC')
            ->get();

        $pickup_date = Carbon::parse($request->pickup_date);
        $dropoff_date = Carbon::parse($search[0]->date);
        // dd($orders[0]->date);
        if ($pickup_date < $dropoff_date) {
            return response()->json([
                'message' => 'Failed !',
            ]);
        } else {
            $orders = orders::create($data);
        }

        if ($orders) {
            return response()->json([
                'message' => 'Success',
                'data' => $orders
            ]);
        } else {
            return response()->json([
                'message' => 'Failed !',
            ]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        $orders = orders::find($id);
        return $orders;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        $data = $request->validate([
            'car_id' => 'required',
            'order_date' => 'required',
            'pickup_date' => 'required',
            'dropoff_date' => 'required',
            'pickup_location' => 'required',
            'dropoff_location' => 'required',
        ]);
        $orders = orders::find($id);
        $orders->update($data);
        return response()->json([
            'message' => 'Order Updated',
            'data' => $orders
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $orders = orders::find($id);
        $orders->delete();
        return response()->json([
            'message' => 'Order Deleted',
            'data' => $orders
        ]);
    }
}
