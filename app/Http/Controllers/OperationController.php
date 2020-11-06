<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Operation;

class OperationController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Stores a new stock code and company name
     * @param Request $request
     * @return jsonResponse
     */
    public function store(Request $request){
        /**
         * Validation
         */
        $this->validate($request, [
            'user_id' => 'required',
            'stock_id' => 'required',
            'quantity' => 'required',
            'unitary_value' => 'required',
            'op_type' => 'required',
        ]);

        $total = $request->json('quantity') * $request->json('unitary_value');
        $request->merge(['total_value' => $total]);

        try {
            $operation = Operation::create($request->json()->all());
            return response()->json(['id' => $operation->id,'message' => 'New operation successfully stored!'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error: ' . $e->getMessage()], 203);
        }
    }
}
