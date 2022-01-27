<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\GiroTransaction;
use Illuminate\Routing\Redirector;


class TransactionsController extends Controller {
    public function new() {
        return view('transactions.new');
    }

    public function view($id) {
        $transaction = GiroTransaction::where('id', $id)->first();
        return view('transactions.edit', compact("transaction"));
    }

    public function edit($id) {
        $transaction = GiroTransaction::find($id)
            ->update(
                [
                    "giro_date" => request('giro_date'),
                    "giro_number" => request('giro_number'),
                    "customer_name" => request('store_name'),
                    "amount" => request('amount')
                ]
            );

        return redirect()->route('index');
    }

    public function submit() {
        $param = [
            "giro_date" => request('giro_date'),
            "giro_number" => request('giro_number'),
            "customer_name" => request('store_name'),
            "amount" => request('amount')
        ];
        $id = GiroTransaction::create($param);
        
        return redirect()->route('index');
    }
}
