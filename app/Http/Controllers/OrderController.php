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
            'order_date' => 'required|date',
            'pickup_date' => 'required|date',
            'dropoff_date' => 'required|date',
            'pickup_location' => 'required|string',
            'dropoff_location' => 'required|string',
        ]);

        // Ambil tanggal dropoff terakhir untuk mobil terkait
        $search = orders::where('car_id', $request->car_id)
            ->orderBy('dropoff_date', 'DESC')
            ->first();

        if ($search) {
            $pickup_date = Carbon::parse($request->pickup_date);
            $last_dropoff_date = Carbon::parse($search->dropoff_date);

            if ($pickup_date < $last_dropoff_date) {
                return response()->json([
                    'message' => 'Failed!',
                ], 422);
            }
        }

        // Simpan order baru
        $order = orders::create($data);

        if ($order) {
            return response()->json([
                'message' => 'Success',
                'data' => $order
            ]);
        } else {
            return response()->json([
                'message' => 'Failed!',
            ], 500);
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
