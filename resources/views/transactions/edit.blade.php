@extends('layouts.app')

@section('title', 'Edit Giro')
@section('content')
<body>
  <link href="{{ asset('css/app.css') }}" rel="stylesheet">

  <form action="{{ route('edit', $transaction->id) }}" enctype="multipart/form-data" method="POST">
    {{ csrf_field() }}
    <div class="form-group mb-3">
        <label for="giroInput" class="form-label">No. Giro</label>
        <input name="giro_number" type="number" class="form-control {{ ($errors->has('giro_number') ? 'border-danger' : '') }}" id="giroInput" placeholder="Angka 6-Digit Giro" value="{{ $transaction->giro_number }}">
        @error ('giro_number')
            <label class="form-label text-danger">{{ $errors->first('giro_number') }}</label>
        @enderror
    </div>

    <div class="form-group mb-3">
      <label for="period" class="form-label">Periode Belanja</label>
      <select name = "period" class="form-select" id="period" placeholder="Pilih Periode Belanja">
        @foreach($periods as $period)
          <option value="{{ $period->id }}" {{ $period->id == $transaction->id_period ? 'selected' : '' }}>{{ $period->name }}</option>
        @endforeach
      </select>
    </div>

    <div class="form-group mb-3">
        <label for="giroDate" class="form-label">Tgl. Bukaan Giro</label>
        <input name="giro_date" type="date" class="form-control {{ ($errors->has('giro_date') ? 'border-danger' : '') }}" id="giroDate" placeholder="Pilih Tanggal" value="{{ $transaction->giro_date }}">
        @error ('giro_date')
            <label class="form-label text-danger">{{ $errors->first('giro_date') }}</label>
        @enderror
    </div>

    <div class="form-group mb-3">
        <label for="nominalInput" class="form-label">Nominal</label>
        <input name="amount" class="form-control {{ ($errors->has('amount') ? 'border-danger' : '') }}" id="amount" type="text" placeholder="Total Bukaan Giro" value="{{ $transaction->amount }}"></textarea>
        @error ('amount')
            <label class="form-label text-danger">{{ $errors->first('amount') }}</label>
        @enderror
    </div>

    <div class="form-group mb-3">
        <label for="nameInput" class="form-label">Nama Toko</label>
        <input name="store_name" class="form-control {{ ($errors->has('store_name') ? 'border-danger' : '') }}" id="nameInput" type="text" placeholder="Nama Toko" value="{{ $transaction->customer_name }}"></textarea>
        @error ('store_name')
            <label class="form-label text-danger">{{ $errors->first('store_name') }}</label>
        @enderror
    </div>

    <div class="form-check form-switch mt-3 mb-3">
      <input class="form-check-input" type="checkbox" id="is_void" name="is_void" {{ $transaction->is_void == 1 ? 'checked' : '' }}>
      <label class="form-check-label" for="is_void">Batalkan Giro / Void Giro</label>
    </div>

    <div class="form-group d-grid gap-2 d-md-flex justify-content-md-end">
      <button type="button" class="btn btn-danger btn-lg" onclick="window.location='{{ route('index') }}'">Cancel</button>
      <button type="submit" class="btn btn-primary btn-lg">Save</button>
    </div>
  </form>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/autonumeric/4.1.0/autoNumeric.min.js"></script>
  <script type="text/javascript">	
      new AutoNumeric('#amount', {
        decimalPlace: '0'
      })
  </script>
</body> 
@endsection