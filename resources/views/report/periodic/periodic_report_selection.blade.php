@extends('layouts.app')

@section('title', 'Pilih Periode Belanja')
@section('content')
<body>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <form method="get" action="/report/periodic" enctype="multipart/form-data">
        {{ csrf_field() }}
        <div class="form-group mb-3">
            <label for="month" class="form-label font-weight-bold">Periode Belanja</label>
            <select class="form-select form-control-lg" name="period">
                @foreach($periods as $period)
                    <option value="{{ $period->id }}">
                        {{ $period->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group d-grid gap-2 d-md-flex justify-content-md-end">
            <button type="submit" class="btn btn-primary btn-lg">Submit</button>
        </div>
    </form>
</body> 
@endsection