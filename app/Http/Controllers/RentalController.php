<?php

namespace App\Http\Controllers;

use App\Models\Houses;
use App\Models\Rentals;
use Illuminate\Http\Request;

class RentalController extends Controller
{
    public function index(){
     return response()->json(Rentals::with(['user','house'])->latest()->get());
    }

    public function store(Request $request){
       $request->validate([
            'user_id' => 'required|exists:users,id',
            'house_id' => 'required|exists:houses,id',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'rent_price' => 'required|numeric',
            'booking_price' => 'nullable|numeric',
            'notes' => 'nullable|string'

       ]);
       Houses::findOrFail($request->house_id)->update(['status' =>'occupied']);
           $rental = Rentals::create($request->all());
           return response()->json($rental->load(['user', 'house']), 201);
    }

    public function update(Request $request, Rentals $rental){
        $request->validate([
            'start_date'=> 'sometimes|date',
            'end_date'   => 'sometimes|date',
            'rent_price' => 'sometimes|numeric',
            'booking_price' => 'sometimes|numeric',
            'status'     => 'in:active,expired,terminated',
            'notes'      => 'nullable|string',
        ]);

if (in_array($request->status, ['expired', 'terminated'])) {
            $rental->house->update(['status' => 'available']);
        }

        $rental->update($request->all());
        return response()->json($rental->load(['user', 'house']));
    }

    public function destroy(Rentals $rental) {
        $rental->house->update(['status' => 'available']);
        $rental->delete();
        return response()->json(['message' => 'Rental deleted']);
    }

}
