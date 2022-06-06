@extends("layouts.base")
@section("content")
@php
  $i=1;
@endphp
<div class="container-fluid">

  <div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-header card-header-primary">
          <h6 class="m-0 font-weight-bold text-primary">Table History Hasil Fuzzy Mahasiswa 3 Tahun Terakhir</h6>
        </div>
        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
              <thead>
                <tr>
                  <th>No</th>
                  <th>Nama</th>
                  <th>Nim</th>
                  <th>Prodi</th>
                  <th>Tahun Lulus</th>
                  <th>IPK</th>
                  <th>Lama Studi</th>
                  <th>SK2PM</th>
                  <th>TOEFL</th>
                  <th>Nilai</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($data as $key => $value)
                @foreach($value as $dt)
                <tr>
                  <td>{{ $i++ }}</td>
                  <td>{{ $dt["nama"] }}</td>
                  <td>{{ $dt["nim"] }}</td>
                  <td>{{ $dt["prodi"] }}</td>
                  <td>{{ $dt["tahun"] }}</td>
                  <td>{{ $dt["ipk"] }}</td>
                  <td>{{ $dt["lama_studi"] }}</td>
                  <td>{{ $dt["sk2pm"] }}</td>
                  <td>{{ $dt["toefl"] }}</td>
                  <td>{{ round($dt["nilai"], 2) }}</td>
                </tr>
                @endforeach
                @endforeach
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
  <br>

  {{-- @foreach ($data as $key => $value)
  <div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-header card-header-primary">
          <h6 class="m-0 font-weight-bold text-primary">Table Hasil Fuzzy Mahasiswa Tahun {{ $key }}</h6>
        </div>
        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-bordered" id="dataTable_{{ $key }}" width="100%" cellspacing="0">
              <thead>
                <tr>
                  <th>No</th>
                  <th>Nama</th>
                  <th>Nim</th>
                  <th>Prodi</th>
                  <th>Tahun Lulus</th>
                  <th>IPK</th>
                  <th>Lama Studi</th>
                  <th>SK2PM</th>
                  <th>TOEFL</th>
                  <th>Nilai</th>
                </tr>
              </thead>
              <tbody>
                @foreach($value as $dt)
                <tr>
                  <td>{{ $loop->iteration }}</td>
                  <td>{{ $dt["nama"] }}</td>
                  <td>{{ $dt["nim"] }}</td>
                  <td>{{ $dt["prodi"] }}</td>
                  <td>{{ $dt["tahun"] }}</td>
                  <td>{{ $dt["ipk"] }}</td>
                  <td>{{ $dt["lama_studi"] }}</td>
                  <td>{{ $dt["sk2pm"] }}</td>
                  <td>{{ $dt["toefl"] }}</td>
                  <td>{{ round($dt["nilai"], 2) }}</td>
                </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
  <br>
  @endforeach --}}
</div>

@endsection
@section("script")

<script>
  $(document).ready(function() {
    @foreach ($data as $key => $value)
      $('#dataTable_{{ $key }}').DataTable();
    @endforeach
  });

</script>

@endsection