<?php

namespace App\Http\Controllers;

use App\Models\Payments;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function index() {
        return response()->json(
            Payments::with(['rental.user', 'rental.house'])->latest()->get()
        );
    }

    public function store(Request $request) {
        $request->validate([
                       'rental_id'  => 'required|exists:rentals,id',
            'amount'     => 'required|numeric',
            'due_date'   => 'required|date',
            'paid_date'  => 'nullable|date',
            'status'     => 'in:paid,unpaid,late',
            'note'       => 'nullable|string',
            'water_old'  => 'nullable|numeric',
            'water_new'  => 'nullable|numeric',
            'water_rate' => 'nullable|numeric',
            'elec_old'   => 'nullable|numeric',
            'elec_new'   => 'nullable|numeric',
            'elec_rate'  => 'nullable|numeric',
            'sanitation' => 'nullable|numeric',
            'wifi'       => 'nullable|numeric',
        ]);

        $payment = Payments::create($request->all());
        return response()->json($payment->load(['rental.user', 'rental.house']), 201);
    }

    public function update(Request $request, Payments $payment) {
        $request->validate([
            'amount'     => 'sometimes|numeric',
            'due_date'   => 'sometimes|date',
            'paid_date'  => 'nullable|date',
            'status'     => 'in:paid,unpaid,late',
            'note'       => 'nullable|string',
            'water_old'  => 'nullable|numeric',
            'water_new'  => 'nullable|numeric',
            'water_rate' => 'nullable|numeric',
            'elec_old'   => 'nullable|numeric',
            'elec_new'   => 'nullable|numeric',
            'elec_rate'  => 'nullable|numeric',
            'booking_price' =>'nullable|numeric',
            'sanitation' => 'nullable|numeric',
            'wifi'       => 'nullable|numeric',
        ]);

        $payment->update($request->all());
        return response()->json($payment->load(['rental.user', 'rental.house']));
    }

    public function destroy(Payments $payment) {
        $payment->delete();
        return response()->json(['message' => 'Payment deleted']);
    }

}
