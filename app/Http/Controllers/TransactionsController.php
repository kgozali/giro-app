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
        $periods = Period::where('is_active', 1)
            ->orderBy('id', 'DESC')
            ->get();
        return view('giro.transactions.new', compact('periods'));
    }

    public function view($id) {
        $periods = Period::where('is_active', 1)
            ->orderBy('id', 'DESC')
            ->get();
        $transaction = GiroTransaction::where('id', $id)->first();
        return view('giro.transactions.edit', compact('transaction', 'periods'));
    }

    public function edit($id, Request $request) {
        $is_valid = request('is_void') == null;
        
        $validated = $request->validate([
            'giro_code' => 'required|size:2',
            'giro_number' => 'required|digits:6',
            'giro_date' => 'required',
            'amount' => 'required',
            'store_name' => 'required'
        ], [
            'giro_code.required' => 'Isi Kode Giro',
            'giro_code.size' => 'Kode Giro Harus 2 Digit',
            'giro_number.required' => 'Isi Nomor Giro',
            'giro_number.digits' => 'No. Giro harus 6 digit',
            'giro_date.required' => 'Isi Tgl. Bukaan Giro',
            'amount.required' => 'Isi Nominal Transaksi',
            'store_name.required' => 'Isi Nama Toko'
        ]);

        $transaction = GiroTransaction::find($id)
            ->update([
                "giro_code" => strtoupper(request('giro_code')),
                "giro_date" => request('giro_date'),
                "giro_number" => request('giro_number'),
                "customer_name" => strtoupper(request('store_name')),
                "amount" => (float) str_replace(',', '', request('amount')),
                "id_period" => request('period'),
                "is_void" => $is_valid ? 0 : 1
            ]);

        if ($transaction != null) {
            Alert::success('Berhasil!', "Data Berhasil Diubah");
        }

        return redirect()->route('giro_index');
    }

    public function submit(Request $request) {
        $is_valid = request('is_void') == null;

        $validated = $request->validate([
            'giro_code' => 'required|size:2',
            'giro_number' => 'required|digits:6',
            'giro_date' => 'required',
            'amount' => 'required',
            'store_name' => 'required'
        ], [
            'giro_code.required' => 'Isi Kode Giro',
            'giro_code.size' => 'Kode Giro Harus 2 Digit',
            'giro_number.required' => 'Isi Nomor Giro',
            'giro_number.digits' => 'No. Giro harus 6 digit',
            'giro_date.required' => 'Isi Tgl. Bukaan Giro',
            'amount.required' => 'Isi Nominal Transaksi',
            'store_name.required' => 'Isi Nama Toko'
        ]);

        $giro = GiroTransaction::firstWhere('giro_number', request('giro_number'));

        if ($giro == null) {
            $param = [
                "giro_code" => strtoupper(request('giro_code')),
                "giro_date" => request('giro_date'),
                "giro_number" => request('giro_number'),
                "customer_name" => strtoupper(request('store_name')),
                "amount" => (float) str_replace(',', '', request('amount')),
                "id_period" => request('period'),
                "is_void" => $is_valid ? 0 : 1
            ];
            $transaction = GiroTransaction::create($param);
    
            if ($transaction != null) {
                Alert::success('Berhasil!', "Data Berhasil Ditambahkan");
            }

            $periods = Period::where('is_active', 1)
                ->orderBy('id', 'DESC')
                ->get();
            return redirect()->route('new_giro', compact('periods'));
        } else {
            Alert::error('Oops!', "Data dengan No. Giro sudah ada");
            return redirect()->back()->withInput();
        }
    }
}
