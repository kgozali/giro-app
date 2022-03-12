<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\GiroTransaction;
use Illuminate\Routing\Redirector;

class MainController extends Controller {
    public function index() {
        $keyword = request('keyword');
        $sort = request('sort') ?? 'giro_date';
        $sort_order = request('sort_order') ?? 'desc';
        $transactions = GiroTransaction::where('customer_name', 'LIKE', '%'.$keyword.'%')
            ->orWhere('giro_number', 'LIKE', '%'.$keyword.'%')
            ->orWhere('amount', 'LIKE', '%'.$keyword.'%')
            ->orderBy($sort, $sort_order)
            ->paginate(20)
            ->through(function($transaction, $key){
                return [
                    'id' => $transaction->id,
                    'created_at' => "$transaction->created_at",
                    'giro_number' => $transaction->giro_number,
                    'giro_date' => $transaction->giro_date,
                    'amount' => $transaction->amount,
                    'customer_name' => $transaction->customer_name,
                    'is_void' => $transaction->is_void,
                    'edit_url' => route('view', $transaction->id)
                ];
            });
            
        return view('home', compact('transactions', 'keyword', 'sort', 'sort_order'));
    }
}
