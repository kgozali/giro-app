<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\GiroTransaction;
use App\Models\Period;
use Illuminate\Routing\Redirector;
use RealRashid\SweetAlert\Facades\Alert;


class TransactionsController extends Controller {
    public function new() {
        $periods = Period::all();
        return view('transactions.new', compact('periods'));
    }

    public function view($id) {
        $periods = Period::all();
        $transaction = GiroTransaction::where('id', $id)->first();
        return view('transactions.edit', compact('transaction', 'periods'));
    }

    public function edit($id) {
        $is_valid = request('is_void') == null;

        $transaction = GiroTransaction::find($id)
            ->update([
                "giro_date" => request('giro_date'),
                "giro_number" => request('giro_number'),
                "customer_name" => request('store_name'),
                "amount" => (float) str_replace(',', '', request('amount')),
                "id_period" => request('period'),
                "is_void" => $is_valid ? 0 : 1
            ]);

        if ($transaction != null) {
            Alert::success('Berhasil!', "Data Berhasil Diubah");
        }

        return redirect()->route('index');
    }

    public function submit() {
        $is_valid = request('is_void') == null;

        $param = [
            "giro_date" => request('giro_date'),
            "giro_number" => request('giro_number'),
            "customer_name" => request('store_name'),
            "amount" => (float) str_replace(',', '', request('amount')),
            "id_period" => request('period'),
            "is_void" => $is_valid ? 0 : 1
        ];
        $transaction = GiroTransaction::create($param);

        if ($transaction != null) {
            Alert::success('Berhasil!', "Data Berhasil Ditambahkan");
        }
        
        $periods = Period::all();
        return redirect()->route('new_giro', compact('periods'));
    }
}
