@extends("layouts.base")
@section("css")
  <style>
    /* Chrome, Safari, Edge, Opera */
    input::-webkit-outer-spin-button,
    input::-webkit-inner-spin-button {
      -webkit-appearance: none;
      margin: 0;
    }

    /* Firefox */
    input[type=number] {
      -moz-appearance: textfield;
    }
  </style>
@endsection
@section("content")

<div class="container-fluid">
  <div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-header card-header-primary">
          <h6 class="m-0 font-weight-bold text-primary">Tambah Data</h6>
        </div>
        <div class="card-body">
          <div class="row">
            <div class="col-md-12">
              <form action="/tambah-data" method="POST">
              @csrf
              <div class="row">
                <div class="col-4">
                  <div class="form-group">
                    <label for="nama">Nama</label>
                    <input type="text" class="form-control" id="nama" aria-describedby="emailHelp" placeholder="Nama" name="nama">
                  </div>
                </div>
                <div class="col-4">
                  <div class="form-group">
                    <label for="nim">NIM</label>
                    <input type="text" class="form-control" id="nim" aria-describedby="emailHelp" placeholder="NIM" name="nim">
                  </div>
                </div>
                <div class="col-4">
                  <div class="form-group">
                    <label for="prodi">Program Studi</label>
                    <input type="text" class="form-control" id="prodi" aria-describedby="emailHelp" placeholder="Program Studi" name="prodi">
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-6">
                  <div class="form-group">
                    <label for="ipk">IPK</label>
                    <input type="text" class="form-control" id="ipk" aria-describedby="emailHelp" placeholder="IPK" name="ipk" min="3" max="4">
                    <small class="text-info">*contoh: 3.50</small>
                  </div>
                </div>
                <div class="col-6">
                  <div class="form-group">
                    <label for="lama_studi">Lama Studi (Bulan)</label>
                    <input type="text" class="form-control" id="lama_studi" aria-describedby="emailHelp" placeholder="Lama Studi" name="lama_studi" min="42">
                  </div>
                </div>
                <div class="col-6">
                  <div class="form-group">
                    <label for="sk2pm">Nilai SK2PM</label>
                    <input type="text" class="form-control" id="sk2pm" aria-describedby="emailHelp" placeholder="Nilai SK2PM" name="sk2pm">
                  </div>
                </div>
                <div class="col-6">
                  <div class="form-group">
                    <label for="toefl">Nilai Toefl</label>
                    <input type="text" class="form-control" id="toefl" aria-describedby="emailHelp" placeholder="Nilai Toefl" name="toefl" max="677">
                  </div>
                </div>
              </div>
              <button class="btn btn-primary">Tambah Data</button>
              </form>
            </div>
          </div>
        </div>
    </div>
  </div>
</div>
<br>

@endsection