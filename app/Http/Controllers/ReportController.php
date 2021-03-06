<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\GiroTransaction;
use App\Models\Period;
use Illuminate\Routing\Redirector;
use Illuminate\Database\Query\Builder;
use DateTime;
use Illuminate\Support\Carbon;

class ReportController extends Controller {
    public function getMonthlyReport() {
        $month = request('month');
        $year = request('year');

        if ($month == null || $year == null) {
            return view('giro.report.monthly.monthly_report_selection');
        } else {
            $date_obj = DateTime::createFromFormat('!m', $month);
            $month_name = Carbon::parse($date_obj)->isoFormat('MMMM');
            $transactions = GiroTransaction::selectRaw('giro_transaction.id, master_period.name, created_at, CONCAT(giro_code, giro_number) AS giro_number, giro_date, amount, UPPER(customer_name) `customer_name`, is_void')
                ->leftJoin('master_period', function($join) {
                    $join->on('giro_transaction.id_period', '=', 'master_period.id');
                })
                ->whereMonth('giro_date', $month)
                ->whereYear('giro_date', $year)
                ->where('is_void', 0)
                ->where('is_deleted', 0)
                ->orderBy('id_period', 'ASC')
                ->orderBy('giro_date', 'ASC')
                ->get();

            $total_amount = GiroTransaction::whereMonth('giro_date', $month)
                ->whereYear('giro_date', $year)
                ->where('is_void', 0)
                ->where('is_deleted', 0)
                ->sum('amount');

            $subtotal = DB::select(DB::raw("
                SELECT SUM(A.total) as total, A.start_date, A.end_date, A.period, A.period_id
                FROM (
                    SELECT 
                        IFNULL(SUM(gt.amount), 0) as total, 
                        (CASE 
                            when day(gt.giro_date) <= 5 then DATE_FORMAT(gt.giro_date,'%Y-%m-01')
                            when day(gt.giro_date) <= 10 then DATE_FORMAT(gt.giro_date,'%Y-%m-6')
                            when day(gt.giro_date) <= 15 then DATE_FORMAT(gt.giro_date,'%Y-%m-11')
                            when day(gt.giro_date) <= 20 then DATE_FORMAT(gt.giro_date,'%Y-%m-16')
                            when day(gt.giro_date) <= 25 then DATE_FORMAT(gt.giro_date,'%Y-%m-21')
                            else DATE_FORMAT(gt.giro_date,'%Y-%m-26')
                        END) as `start_date`,
                        (CASE 
                            when day(gt.giro_date) <= 5 then DATE_FORMAT(gt.giro_date,'%Y-%m-5')
                            when day(gt.giro_date) <= 10 then DATE_FORMAT(gt.giro_date,'%Y-%m-10')
                            when day(gt.giro_date) <= 15 then DATE_FORMAT(gt.giro_date,'%Y-%m-15')
                            when day(gt.giro_date) <= 20 then DATE_FORMAT(gt.giro_date,'%Y-%m-20')
                            when day(gt.giro_date) <= 25 then DATE_FORMAT(gt.giro_date,'%Y-%m-25')
                            else LAST_DAY(gt.giro_date)
                        END) as `end_date`,
                        mp.id `period_id`,
                        mp.name `period`
                        FROM giro_transaction gt
                        LEFT JOIN master_period mp ON mp.id = gt.id_period
                        WHERE MONTH(gt.giro_date) = :month AND YEAR(gt.giro_date) = :year AND gt.is_void = 0 AND gt.is_deleted = 0
                        GROUP BY gt.giro_date, mp.id, mp.name
                        ORDER BY DAY(start_date)
                ) as A    
                GROUP BY A.start_date, A.end_date, A.period_id, A.period
                ORDER BY DAY(A.start_date), A.period_id
            "), array(
                'month' => $month,
                'year' => $year
            ));

            $summary = collect($subtotal)
                ->groupBy('start_date')
                ->map(function ($group, $keys) {
                    return [
                        'total' => $group->sum('total'),
                        'start_date' => $group->first()->start_date,
                        'end_date' => $group->first()->end_date
                    ];
                });

            return view('giro.report.monthly.monthly_report', compact('transactions', 'summary', 'subtotal', 'month_name', 'year', 'total_amount'));
        }
    }

    public function getPeriodicReport() {
        $period = request('period');

        if ($period == null) {
            $periods = Period::where('is_active', 1)
                ->orderBy('id', 'DESC')
                ->get();
            return view('giro.report.periodic.periodic_report_selection', compact('periods'));
        } else {
            $transactions = GiroTransaction::where('id_period', $period)
                ->selectRaw("giro_transaction.id, created_at, CONCAT(giro_code, giro_number) AS giro_number, giro_date, amount, UPPER(customer_name) `customer_name`, is_void, IF(is_void = 1, 'BATAL / VOID', '') AS `status`")
                ->where('is_deleted', 0)
                ->orderByRaw('CONCAT(giro_code, giro_number) ASC')
                ->get();

            $summary = collect($transactions)
                ->where('is_void', 0)
                ->sum('amount');
            $period = Period::whereId($period)->first();

            return view('giro.report.periodic.periodic_report', compact('transactions', 'summary', 'period'));
        }
    }

    public function getMonthlyPeriodicReport() {
        $month = request('month');
        $year = request('year');
        $period = request('period');

        if ($month == null || $year == null || $period == null) {
            $periods = Period::where('is_active', 1)
                ->orderBy('id', 'DESC')
                ->get();
            return view('giro.report.periodic.monthly_periodic_report_selection', compact('periods'));
        } else {
            $date_obj = DateTime::createFromFormat('!m', $month);
            $month_name = Carbon::parse($date_obj)->isoFormat('MMMM');
            $transactions = GiroTransaction::selectRaw('giro_transaction.id, master_period.name, created_at, CONCAT(giro_code, giro_number) AS giro_number, giro_date, amount, UPPER(customer_name) `customer_name`, is_void')
                ->leftJoin('master_period', function($join) {
                    $join->on('giro_transaction.id_period', '=', 'master_period.id');
                })
                ->whereMonth('giro_date', $month)
                ->whereYear('giro_date', $year)
                ->where('id_period', $period)
                ->where('is_void', 0)
                ->where('is_deleted', 0)
                ->orderBy('id_period', 'ASC')
                ->orderBy('giro_date', 'ASC')
                ->get();

            $total_amount = GiroTransaction::whereMonth('giro_date', $month)
                ->whereYear('giro_date', $year)
                ->where('id_period', $period)
                ->where('is_void', 0)
                ->where('is_deleted', 0)
                ->sum('amount');

            $subtotal = DB::select(DB::raw("
                SELECT SUM(A.total) as total, A.start_date, A.end_date, A.period, A.period_id
                FROM (
                    SELECT 
                        IFNULL(SUM(gt.amount), 0) as total, 
                        (CASE 
                            when day(gt.giro_date) <= 5 then DATE_FORMAT(gt.giro_date,'%Y-%m-01')
                            when day(gt.giro_date) <= 10 then DATE_FORMAT(gt.giro_date,'%Y-%m-6')
                            when day(gt.giro_date) <= 15 then DATE_FORMAT(gt.giro_date,'%Y-%m-11')
                            when day(gt.giro_date) <= 20 then DATE_FORMAT(gt.giro_date,'%Y-%m-16')
                            when day(gt.giro_date) <= 25 then DATE_FORMAT(gt.giro_date,'%Y-%m-21')
                            else DATE_FORMAT(gt.giro_date,'%Y-%m-26')
                        END) as `start_date`,
                        (CASE 
                            when day(gt.giro_date) <= 5 then DATE_FORMAT(gt.giro_date,'%Y-%m-5')
                            when day(gt.giro_date) <= 10 then DATE_FORMAT(gt.giro_date,'%Y-%m-10')
                            when day(gt.giro_date) <= 15 then DATE_FORMAT(gt.giro_date,'%Y-%m-15')
                            when day(gt.giro_date) <= 20 then DATE_FORMAT(gt.giro_date,'%Y-%m-20')
                            when day(gt.giro_date) <= 25 then DATE_FORMAT(gt.giro_date,'%Y-%m-25')
                            else LAST_DAY(gt.giro_date)
                        END) as `end_date`,
                        mp.id `period_id`,
                        mp.name `period`
                        FROM giro_transaction gt
                        LEFT JOIN master_period mp ON mp.id = gt.id_period
                        WHERE MONTH(gt.giro_date) = :month AND YEAR(gt.giro_date) = :year AND gt.id_period = :period AND gt.is_void = 0 AND gt.is_deleted = 0
                        GROUP BY gt.giro_date, mp.id, mp.name
                        ORDER BY DAY(start_date)
                ) as A    
                GROUP BY A.start_date, A.end_date, A.period_id, A.period
                ORDER BY DAY(A.start_date), A.period_id
            "), array(
                'month' => $month,
                'year' => $year,
                'period' => $period
            ));

            $summary = collect($subtotal)
                ->groupBy('start_date')
                ->map(function ($group, $keys) {
                    return [
                        'total' => $group->sum('total'),
                        'start_date' => $group->first()->start_date,
                        'end_date' => $group->first()->end_date
                    ];
                });

            return view('giro.report.monthly.monthly_report', compact('transactions', 'summary', 'subtotal', 'month_name', 'year', 'total_amount'));
        }
    }

    public function getGiroBookReport() {
        $code = request('giro_code');
        $min = request('giro_number_min');
        $max = request('giro_number_max');
        
        if ($code == null || $min == null || $max == null) {
            $giro_codes = GiroTransaction::select('giro_code')
                ->groupBy('giro_code')
                ->get();
            return view('giro.report.girobook.giro_book_selection', compact('giro_codes'));
        } else {
            $transactions = GiroTransaction::selectRaw("giro_transaction.id, created_at, CONCAT(giro_code, giro_number) AS giro_number, giro_date, amount, UPPER(customer_name) `customer_name`, is_void, IF(is_void = 1, 'BATAL / VOID', '') AS `status`")
                ->whereRaw("CONVERT(giro_number, UNSIGNED) BETWEEN ? AND ?", [$min, $max])
                ->where('giro_code', $code)
                ->where('is_deleted', 0)
                ->orderByRaw('CONCAT(giro_code, giro_number) ASC')
                ->get();

            $summary = collect($transactions)
                ->where('is_void', 0)
                ->sum('amount');

            return view('giro.report.girobook.giro_book_report', compact('transactions', 'summary', 'code', 'min', 'max'));
        }
    }
}
