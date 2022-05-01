@extends('layouts.app')

@section('title', 'Tambah Giro')
@section('content')
<body>
  <link href="{{ asset('css/app.css') }}" rel="stylesheet">

  <form method="post" action="{{ route('submit_giro') }}" enctype="multipart/form-data">
    {{ csrf_field() }}

    <div class="form-group mb-3">
        <label for="giro_code" class="form-label">Kode Giro</label>
        <input name="giro_code" type="text" class="form-control {{ ($errors->has('giro_code') ? 'border-danger' : '') }}" id="giro_code" placeholder="Kode Giro" value="{{ old('giro_code') }}">
        @error ('giro_code')
            <label class="form-label text-danger">{{ $errors->first('giro_code') }}</label>
        @enderror
    </div>

    <div class="form-group mb-3">
        <label for="giro_number" class="form-label">No. Giro</label>
        <input name="giro_number" type="number" class="form-control {{ ($errors->has('giro_number') ? 'border-danger' : '') }}" id="giro_number" placeholder="Angka 6-Digit Giro" value="{{ old('giro_number') }}">
        @error ('giro_number')
            <label class="form-label text-danger">{{ $errors->first('giro_number') }}</label>
        @enderror
    </div>

    <div class="form-group mb-3">
      <label for="period" class="form-label">Periode Belanja</label>
      <select name = "period" class="form-select" id="period" placeholder="Pilih Periode Belanja">
        @foreach($periods as $period)
          <option value="{{ $period->id }}">{{ $period->name }}</option>
        @endforeach
      </select>
    </div>

    <div class="form-group mb-3">
        <label for="giro_date" class="form-label">Tgl. Bukaan Giro</label>
        <input name="giro_date" type="date" class="form-control {{ ($errors->has('giro_date') ? 'border-danger' : '') }}" id="giro_date" placeholder="Pilih Tanggal" value="{{ old('giro_date') }}">
        @error ('giro_date')
            <label class="form-label text-danger">{{ $errors->first('giro_date') }}</label>
        @enderror
    </div>

    <div class="form-group mb-3">
        <label for="amount" class="form-label">Nominal</label>
        <input name="amount" class="form-control {{ ($errors->has('amount') ? 'border-danger' : '') }}" id="amount" type="text" placeholder="Total Bukaan Giro" value="{{ old('amount') }}"></textarea>
        @error ('amount')
            <label class="form-label text-danger">{{ $errors->first('amount') }}</label>
        @enderror
    </div>

    <div class="form-group mb-3">
        <label for="store_name" class="form-label">Nama Toko</label>
        <input name="store_name" class="form-control {{ ($errors->has('store_name') ? 'border-danger' : '') }}" id="store_name" type="text" placeholder="Nama Toko" value="{{ old('store_name') }}"></textarea>
        @error ('store_name')
            <label class="form-label text-danger">{{ $errors->first('store_name') }}</label>
        @enderror
    </div>

    <div class="form-check form-switch mt-3 mb-3">
      <input class="form-check-input" type="checkbox" id="is_void" name="is_void">
      <label class="form-check-label" for="is_void">Batalkan Giro / Void Giro</label>
    </div>

    <div class="form-group d-grid gap-2 d-md-flex justify-content-md-end">
      <button type="button" class="btn btn-danger btn-lg" onclick="window.location='{{ route('giro_index') }}'">Close</button>
      <button type="submit" class="btn btn-primary btn-lg">Save</button>
    </div>
  </form>
  
  <script type="text/javascript">	
      new AutoNumeric('#amount', {
        decimalPlace: '0'
      })
  </script>
</body> 
@endsection