@extends('layouts.app')

@section('content')
<body>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <h2 class="mb-3">{{ 'Laporan Periode Belanja' }}</h4>
    <h4 class="mb-4 text-muted">{{ $period->name }}</h4>

    <table class="table table-bordered">
        <thead class="table-light">
            <tr>
                <th style="width: 20%" scope="col-md-4">No. Giro</th>
                <th style="width: 20%" scope="col-md-4">Tgl. Giro</th>
                <th style="width: 20%" scope="col-md-4">Nama Toko</th>
                <th style="width: 20%" scope="col-md-4">Status</th>
                <th style="width: 20%" scope="col-md-4">Nominal</th>
            </tr>
        </thead>
        <tbody>
            @foreach($transactions as $transaction)
               <tr class={{ $transaction['is_void'] == 1 ? 'table-danger' : '' }}>
                    <td>{{ $transaction['giro_number'] }}</td>
                    <td>{{ date('j M Y', strtotime($transaction['giro_date'])) }}</td>
                    <td>{{ $transaction['customer_name'] }}</td>
                    <td><b>{{ $transaction['status'] }}</b></td>
                    @if($transaction['is_void'] == 1)
                        <td class="text-secondary"><del>{{ number_format($transaction['amount'], 0) }}</del></td>
                    @else
                        <td><b>{{ number_format($transaction['amount'], 0) }}</b></td>
                    @endif
                </tr>
            @endforeach
        </tbody>
    </table>

    <table class="table table-bordered">
        <thead class="table-light">
            <tr class="table-success">
                <th style="width: 60%" colspan=3></th>
                <th style="width: 20%">TOTAL</th>
                <th style="width: 20%">{{ number_format($summary, 0) }}</th>
            </tr>
        </thead>
    </table>
</body> 
@endsection