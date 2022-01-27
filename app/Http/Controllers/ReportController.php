<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\GiroTransaction;
use Illuminate\Routing\Redirector;
use Illuminate\Database\Query\Builder;
use DateTime;


class ReportController extends Controller {
    public function select() {
        $month = request('month');
        $year = request('year');

        if ($month == null || $year == null) {
            return view('report.selection');
        } else {
            $dateObj   = DateTime::createFromFormat('!m', $month);
            $monthName = $dateObj->format('F');
            $transactions = GiroTransaction::whereMonth('giro_date', $month)
                ->whereYear('giro_date', $year)
                ->orderBy('giro_date', 'ASC')
                ->get();

            $total_amount = GiroTransaction::whereMonth('giro_date', $month)
                ->whereYear('giro_date', $year)
                ->sum('amount');

            $summary = DB::select(DB::raw("
                SELECT SUM(A.total) as total, A.start_date, A.end_date
                FROM (
                    SELECT 
                        SUM(amount) as total, 
                        (CASE 
                            when day(giro_date) <= 5 then DATE_FORMAT(giro_date,'%Y-%m-01')
                            when day(giro_date) <= 10 then DATE_FORMAT(giro_date,'%Y-%m-6')
                            when day(giro_date) <= 15 then DATE_FORMAT(giro_date,'%Y-%m-11')
                            when day(giro_date) <= 20 then DATE_FORMAT(giro_date,'%Y-%m-16')
                            when day(giro_date) <= 25 then DATE_FORMAT(giro_date,'%Y-%m-21')
                            else DATE_FORMAT(giro_date,'%Y-%m-26')
                        END) as `start_date`,
                        (CASE 
                            when day(giro_date) <= 5 then DATE_FORMAT(giro_date,'%Y-%m-5')
                            when day(giro_date) <= 10 then DATE_FORMAT(giro_date,'%Y-%m-10')
                            when day(giro_date) <= 15 then DATE_FORMAT(giro_date,'%Y-%m-15')
                            when day(giro_date) <= 20 then DATE_FORMAT(giro_date,'%Y-%m-20')
                            when day(giro_date) <= 25 then DATE_FORMAT(giro_date,'%Y-%m-25')
                            else LAST_DAY(giro_date)
                        END) as `end_date`
                        FROM giro_transaction
                        WHERE MONTH(giro_date) = :month AND YEAR(giro_date) = :year
                        GROUP BY giro_date
                        ORDER BY DAY(start_date)
                ) as A    
                GROUP BY A.start_date, A.end_date
                ORDER BY DAY(A.start_date)
            "), array(
                'month' => $month,
                'year' => $year
            ));

            return view('report.view', compact('transactions', 'summary', 'monthName', 'year', 'total_amount'));
        }
    }
}
