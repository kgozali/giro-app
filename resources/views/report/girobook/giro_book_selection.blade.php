@extends('layouts.app')

@section('title', 'Pilih Range Giro')
@section('content')
<body>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <form method="GET" action="/report/giro" enctype="multipart/form-data">
        {{ csrf_field() }}
        <div class="form-group mb-3">
            <label for="month" class="form-label font-weight-bold">Kode Giro</label>
            <select class="form-select form-control-lg" name="giro_code">
                @foreach($giro_codes as $giro_code)
                    <option value="{{ $giro_code->giro_code }}">
                        {{ $giro_code->giro_code }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group mb-3">
            <label for="giro_number_min" class="form-label">Mulai Dari Giro</label>
            <input name="giro_number_min" type="number" class="form-control {{ ($errors->has('giro_number_min') ? 'border-danger' : '') }}" id="giro_number_min" placeholder="Angka 6-Digit Giro" value="{{ old('giro_number_min') }}">
            @error ('giro_number_min')
                <label class="form-label text-danger">{{ $errors->first('giro_number_min') }}</label>
            @enderror
        </div>

        <div class="form-group mb-3">
            <label for="giro_number_max" class="form-label">Sampai Dengan Giro</label>
            <input name="giro_number_max" type="number" class="form-control {{ ($errors->has('giro_number_max') ? 'border-danger' : '') }}" id="giro_number_max" placeholder="Angka 6-Digit Giro" value="{{ old('giro_number_max') }}">
            @error ('giro_number_max')
                <label class="form-label text-danger">{{ $errors->first('giro_number_max') }}</label>
            @enderror
        </div>


        <div class="form-group d-grid gap-2 d-md-flex justify-content-md-end">
            <button type="submit" class="btn btn-primary btn-lg">Submit</button>
        </div>
    </form>
</body> 
@endsection