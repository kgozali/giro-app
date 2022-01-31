@extends('layouts.app')

@section('content')
<body>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <h2 class="mb-4">{{ 'Laporan Bulanan Giro' . ' ' . $month_name . ' ' . $year }}</h4>

    @foreach($summary as $group)
    <h4 class="mt-4 text-muted">{{ date('j F Y', strtotime($group['start_date'])) . ' s/d ' . date('j F Y', strtotime($group['end_date'])) }}</h4>

    <table class="table table-bordered">
        <thead class="table-light">
            <tr>
                <th style="width: 20%" scope="col-md-4">No. Giro</th>
                <th style="width: 20%" scope="col-md-4">Periode Belanja</th>
                <th style="width: 20%" scope="col-md-4">Tgl. Giro</th>
                <th style="width: 20%" scope="col-md-4">Nama Toko</th>
                <th style="width: 20%" scope="col-md-4">Nominal</th>
            </tr>
        </thead>
        <tbody>
            @foreach($transactions as $transaction)
                @php
                    $data_start_date = strtotime($group['start_date']);
                    $data_end_date = strtotime($group['end_date']);
                    $data_giro_date = strtotime($transaction['giro_date']);
                @endphp

                @if(($data_giro_date >= $data_start_date) && ($data_giro_date <= $data_end_date))
                    <tr>
                        <td>{{ $transaction['giro_number'] }}</td>
                        <td>{{ $transaction['name'] }}</td>
                        <td>{{ date('j M Y', strtotime($transaction['giro_date'])) }}</td>
                        <td>{{ $transaction['customer_name'] }}</td>
                        <td>{{ number_format($transaction['amount'], 0) }}</td>
                    </tr>
                @endif
            @endforeach
        </tbody>
        <tfoot>
            @foreach($subtotal as $sub)
                    @php
                    $subtotal_start_date = strtotime($sub->start_date);
                    $subtotal_giro_date = strtotime($group['start_date']);
                @endphp

                @if(($subtotal_start_date == $subtotal_giro_date))
                    <tr class="table-info">
                        <th style="width: 60%" colspan=3></th>
                        <th style="width: 20%">{{ $sub->period }}</th>
                        <th style="width: 20%">{{ number_format($sub->total, 0) }}</th>
                    </tr>
                @endif
            @endforeach

            <tr class="table-warning">
                <th style="width: 60%" colspan=3></th>
                <th style="width: 20%">SUBTOTAL</th>
                <th style="width: 20%">{{ number_format($group['total'], 0) }}</th>
            </tr>
        </tfoot>
    </table>
    @endforeach

    <table class="table table-bordered">
        <thead class="table-light">
            <tr class="table-success">
                <th style="width: 60%" colspan=3></th>
                <th style="width: 20%">TOTAL</th>
                <th style="width: 20%">{{ number_format($total_amount, 0) }}</th>
            </tr>
        </thead>
    </table>
</body> 
@endsection