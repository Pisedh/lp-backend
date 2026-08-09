<?php

namespace App\Http\Controllers;

use App\Models\Houses;
use Illuminate\Http\Request;

class HouseController extends Controller
{
    public function index(){
        return response()->json(Houses::all());
    }
    public function store(Request $request){
        $request->validate([
            'name' => 'required|string',
            'address' => 'nullable|string',
            'room_number'=> 'required|string|unique:houses',
            'price'=> "required|numeric",
            'status'=> 'in:available,occupied',
            'description' => 'nullable|string'


        ]);
        return response()->json(Houses::create($request->all()),201);
    }

    public function show(Houses $house)
    { return
    response()->json($house); 
    }
    public function update(Request $request, Houses $house) {
        $request->validate([
            'name'        => 'sometimes|string',
            'room_number' => 'sometimes|string|unique:houses,room_number,'. $house->id,
            'price'       => 'sometimes|numeric',
            'address'     => 'nullable|string',
            'description' => 'nullable|string',
            'status'      => 'in:available,occupied',
        ]);
        $house->update($request->all());
        return response()->json($house);
    }

    public function destroy(Houses $house) {
        $house->delete();
        return response()->json(['message' => 'House deleted']);
    }

}
