@extends('layouts.app')

@section('title', 'Pilih Periode & Bulan Belanja')
@section('content')
<body>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <form method="GET" action="/report/monthperiod" enctype="multipart/form-data">
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

        <div class="form-group mb-3">
            <label for="month" class="form-label font-weight-bold">Bulan</label>
            <select class="form-select form-control-lg" name="month">
                @foreach(range(1,12) as $month)
                    <option value="{{$month}}">
                        {{date("F", strtotime('2016-'.$month))}}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group mb-3">
            <label for="year" class="form-label font-weight-bold">Tahun</label>
            <select class="mb-3 form-select form-control-lg" name="year">
                @for ($year = date('Y'); $year > date('Y') - 10; $year--)
                    <option value="{{$year}}">
                        {{$year}}
                    </option>
                @endfor
            </select>
        </div>

        <div class="form-group d-grid gap-2 d-md-flex justify-content-md-end">
            <button type="submit" class="btn btn-primary btn-lg">Submit</button>
        </div>
    </form>
</body> 
@endsection