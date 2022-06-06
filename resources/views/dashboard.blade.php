@extends("layouts.base")
@section("content")

<div class="container-fluid">
  <div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-header card-header-primary">
          <h6 class="m-0 font-weight-bold text-primary">Kurva Himpunan Fuzzy</h6>
        </div>
        <div class="card-body">
          <div class="row">
            <div class="col-md-3">
              <img src="{{ asset("grafik/IPK.png") }}" class="img-fluid h-100" alt="IPK">
            </div>
            <div class="col-md-3">
              <img src="{{ asset("grafik/Lama Studi.png") }}" class="img-fluid h-100" alt="IPK">
            </div>
            <div class="col-md-3">
              <img src="{{ asset("grafik/Nilai SK2PM.png") }}" class="img-fluid h-100" alt="IPK">
            </div>
            <div class="col-md-3">
              <img src="{{ asset("grafik/Nilai TOEFL.png") }}" class="img-fluid h-100" alt="IPK">
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <br>
  <div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-header card-header-primary">
          <h6 class="m-0 font-weight-bold text-primary">Table Hasil Fuzzy</h6>
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
                @foreach($data as $dt)
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
</div>

@endsection