<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Operation;
use App\Models\Stock;
use App\Models\Wallet;

class WalletController extends Controller
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
     * Return all investments status
     * @param Integer user_id
     */
    public function index($id){

        $ops = array();

        foreach($wallets = Wallet::where('user_id', $id)->get() as $wallet){
            $total = 0;
            $qtd = 0;
            foreach($operations = Operation::where('user_id', $id)
                                    ->where('stock_id', $wallet->stock_id)
                                    ->where('op_type', 'B')
                                    ->get()
                     as $operation){
                $total += $operation->total_value;
                $qtd += $operation->quantity;
            }

            $stock = Stock::find($wallet->stock_id);
            $ops[$stock->code]['total'] = $total;
            $ops[$stock->code]['quantity'] = $qtd;
            $ops[$stock->code]['minimum_value'] = $total / $qtd;
        }

        return response()->json(['wallet' => json_encode($ops),'message' => 'Wallet recovered successfully!'], 200);
    }

    /**
     * Returns profit or loss in a simulation
     */
    public function profit(Request $request){
        $ops = array();
        
        foreach($wallets = Wallet::where('user_id', $request->json('user_id'))
                            ->where('stock_id', $request->json('stock_id'))
                            ->get() as $wallet){
            $total = 0;
            $qtd = 0;
            foreach($operations = Operation::where('user_id', $request->json('user_id'))
                                    ->where('stock_id', $wallet->stock_id)
                                    ->where('op_type', 'B')
                                    ->get()
                     as $operation){
                $total += $operation->total_value;
                $qtd += $operation->quantity;
            }

            $stock = Stock::find($wallet->stock_id);
            $ops[$stock->code]['total'] = $total;
            $ops[$stock->code]['quantity'] = $qtd;
            $ops[$stock->code]['minimum_value'] = $total / $qtd;
            $ops[$stock->code]['sell_value'] = $request->json('sell_value') * $qtd;
            $ops[$stock->code]['profitloss'] = $ops[$stock->code]['sell_value'] - $total;
        }

        return response()->json(['wallet' => json_encode($ops),'message' => 'Wallet recovered successfully!'], 200);
    }
}
