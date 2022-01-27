@extends('layouts.app')

@section('title', 'Tambah Giro')
@section('content')
<body>
  <link href="{{ asset('css/app.css') }}" rel="stylesheet">
  <script src="js/easy-number-separator.js"></script>

  <form method="post" action="/submit" enctype="multipart/form-data">
    {{ csrf_field() }}
    <div class="form-group mb-3">
        <label for="giroInput" class="form-label">No. Giro</label>
        <input name="giro_number" type="number" class="form-control" id="giroInput" placeholder="Angka 6-Digit Giro">
    </div>

    <div class="form-group mb-3">
        <label for="giroDate" class="form-label">Tgl. Bukaan Giro</label>
        <input name="giro_date" type="date" class="form-control" id="giroDate" name="dob" placeholder="Pilih Tanggal">
    </div>

    <div class="form-group mb-3">
        <label for="nominalInput" class="form-label">Nominal</label>
        <input name="amount" class="form-control" id="nominalInput" type="number" placeholder="Total Bukaan Giro"></textarea>
    </div>

    <div class="form-group mb-3">
        <label for="nameInput" class="form-label">Nama Toko</label>
        <input name="store_name" class="form-control" id="nameInput" type="text" placeholder="Nama Toko"></textarea>
    </div>

    <div class="form-group d-grid gap-2 d-md-flex justify-content-md-end">
      <button type="button" class="btn btn-danger btn-lg">Cancel</button>
      <button type="submit" class="btn btn-primary btn-lg">Save</button>
    </div>
  </form>
</body> 
@endsection