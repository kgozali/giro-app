@extends('layouts.app')

@section('title', 'Edit Giro')
@section('content')
<body>
  <link href="{{ asset('css/app.css') }}" rel="stylesheet">

  <form method="post" action="{{ route('edit', $transaction->id) }}" enctype="multipart/form-data" method="POST">
    {{ csrf_field() }}
    <div class="form-group mb-3">
        <label for="giroInput" class="form-label">No. Giro</label>
        <input name="giro_number" type="number" class="form-control" id="giroInput" placeholder="Angka 6-Digit Giro" value="{{ $transaction->giro_number }}">
    </div>

    <div class="form-group mb-3">
        <label for="giroDate" class="form-label">Tgl. Bukaan Giro</label>
        <input name="giro_date" type="date" class="form-control" id="giroDate" placeholder="Pilih Tanggal" value="{{ $transaction->giro_date }}">
    </div>

    <div class="form-group mb-3">
        <label for="nominalInput" class="form-label">Nominal</label>
        <input name="amount" class="form-control" id="nominalInput" type="number" placeholder="Total Bukaan Giro" value="{{ $transaction->amount }}"></textarea>
    </div>

    <div class="form-group mb-3">
        <label for="nameInput" class="form-label">Nama Toko</label>
        <input name="store_name" class="form-control" id="nameInput" type="text" placeholder="Nama Toko" value="{{ $transaction->customer_name }}"></textarea>
    </div>

    <div class="form-group d-grid gap-2 d-md-flex justify-content-md-end">
      <button type="button" class="btn btn-danger btn-lg">Cancel</button>
      <button type="submit" class="btn btn-primary btn-lg">Save</button>
    </div>
  </form>
</body> 
@endsection