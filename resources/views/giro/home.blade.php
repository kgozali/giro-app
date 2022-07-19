@extends('layouts.app')

@section('title', 'Dashboard')
@section('content')
<body>
    <form method="get" action="{{ route('giro_index', ['keyword' => $keyword]) }}" enctype="multipart/form-data">
        <div class="input-group mb-3">
            <input name="keyword" type="text" class="form-control" placeholder="Cari Transaksi" aria-label="Search For Giro" aria-describedby="button-addon2" value="{{ $keyword }}">
            <button class="btn btn-outline-secondary" type="submit" id="button-addon2">Search</button>
        </div>
    </form>
    

    @if(! $transactions->isEmpty())
    <div class="dropdown mb-3 d-grid gap-2 d-md-flex justify-content-md-start">        
        <a class="btn btn-secondary btn-lg dropdown-toggle" href="#" role="button" id="dropdownSort" data-bs-toggle="dropdown" aria-expanded="false">Urutkan</a>
        <ul class="dropdown-menu" aria-labelledby="dropdownSort">
            <li><a class="dropdown-item" href="{{ route('giro_index', ['sort' => 'id', 'sort_order' => 'desc', 'keyword' => $keyword]) }}">Data Terbaru</a></li>
            <li><a class="dropdown-item" href="{{ route('giro_index', ['sort' => 'giro_number', 'sort_order' => 'asc', 'keyword' => $keyword]) }}">No. Giro</a></li>
            <li><a class="dropdown-item" href="{{ route('giro_index', ['sort' => 'giro_date', 'sort_order' => 'desc', 'keyword' => $keyword]) }}">Tgl. Giro Terbaru</a></li>
            <li><a class="dropdown-item" href="{{ route('giro_index', ['sort' => 'giro_date', 'sort_order' => 'asc', 'keyword' => $keyword]) }}">Tgl. Giro Terlama</a></li>
            <li><a class="dropdown-item" href="{{ route('giro_index', ['sort' => 'amount', 'sort_order' => 'desc', 'keyword' => $keyword]) }}">Nominal Terbesar</a></li>
            <li><a class="dropdown-item" href="{{ route('giro_index', ['sort' => 'amount', 'sort_order' => 'asc', 'keyword' => $keyword]) }}">Nominal Terkecil</a></li>
        </ul>
    </div>
    @endif 
    

    @if(! $transactions->isEmpty())
    <table class="table table-bordered">
        <thead class="table-light">
            <tr>
            <th scope="col">No. Giro</th>
            <th scope="col">Tgl. Giro</th>
            <th scope="col">Nominal</th>
            <th scope="col">Nama Toko</th>
            <th scope="col">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($transactions as $transaction)
                <tr class="{{ $transaction['is_void'] == '1' ? 'table-danger' : '' }}">
                    <td>{{ $transaction['giro_number'] }}</td>
                    <td>{{ date('j M Y', strtotime($transaction['giro_date'])) }}</td>
                    <td>{{ number_format($transaction['amount'], 0) }}</td>
                    <td>{{ $transaction['customer_name'] }}</td>
                    <td><a href="{{ $transaction['edit_url'] }}">Edit</a></td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="d-flex justify-content-center">
        {!! $transactions->appends(request()->input())->links() !!}
    </div>
    @endif  
</body> 
@endsection