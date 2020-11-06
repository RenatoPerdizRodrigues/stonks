<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Stock;

class StockController extends Controller
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
            'code' => 'required',
            'company' => 'required',
        ]);

        try {
            $stock = Stock::create($request->json()->all());
            return response()->json(['id' => $stock->id,'message' => 'New code successfully created!'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error: ' . $e->getMessage()], 203);
        }
    }

    /**
     * Updates stock information
     * @param Request $request
     * @return jsonResponse
     */
    public function update(Request $request, $id){
        if($stock = Stock::find($id)){
            /**
             * Validation
             */
            $this->validate($request, [
                'code' => 'required',
                'company' => 'required',
            ]);

            $stock->update($request->json()->all());
            return response()->json(['stock' => $stock,'message' => 'Code updated!'], 200);
        } else {
            return response()->json(['message' => 'Code not found!'], 204);
        }
    }
    
}
