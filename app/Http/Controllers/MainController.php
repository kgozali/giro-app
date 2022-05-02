<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\GiroTransaction;
use Illuminate\Routing\Redirector;

class MainController extends Controller {
    public function welcome() {
        return view('welcome');
    }

    public function index() {
        $keyword = request('keyword');
        $sort = request('sort') ?? 'giro_date';
        $sort_order = request('sort_order') ?? 'desc';
        $transactions = GiroTransaction::selectRaw('giro_transaction.id, created_at, CONCAT(giro_code, giro_number) AS giro_number, giro_date, amount, UPPER(customer_name) `customer_name`, is_void')
            ->leftJoin('master_period', function($join) {
                $join->on('giro_transaction.id_period', '=', 'master_period.id');
            })
            ->where('is_active', 1)
            ->where('is_deleted', 0)
            ->where('customer_name', 'LIKE', '%'.$keyword.'%')
            ->orWhere('giro_code', 'LIKE', '%'.$keyword.'%')
            ->orWhere('giro_number', 'LIKE', '%'.$keyword.'%')
            ->orWhere('amount', 'LIKE', '%'.$keyword.'%')
            ->orWhereRaw("CONCAT(giro_code, giro_number) LIKE ?", ['%'.$keyword.'%'])
            ->orderBy($sort, $sort_order)
            ->paginate(50)
            ->through(function($transaction, $key){
                return [
                    'id' => $transaction->id,
                    'created_at' => "$transaction->created_at",
                    'giro_number' => $transaction->giro_number,
                    'giro_date' => $transaction->giro_date,
                    'amount' => $transaction->amount,
                    'customer_name' => $transaction->customer_name,
                    'is_void' => $transaction->is_void,
                    'edit_url' => route('view_giro', $transaction->id)
                ];
            });
            
        return view('giro.home', compact('transactions', 'keyword', 'sort', 'sort_order'));
    }
}
