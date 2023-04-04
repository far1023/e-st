@extends('back.layouts.main')

@section('content')
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">{{ $title }}</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Data</a></li>
            <li class="breadcrumb-item active">Peta Situasi Tanah</li>
          </ol>
        </div>
      </div>
    </div>
  </div>

  <div class="content">
    <div class="container-fluid">
      <div class="card">
        <div class="card-body table-responsive px-0 py-4">
          <div class="mx-3">
            <a href="{{ url('formulir/peta-situasi-tanah') }}" class="btn btn-sm btn-outline-primary float-right px-3">
              <i class="fa fa-fw fa-plus"></i> Pengajuan Baru
            </a>
          </div>
          <table class="table table-striped table-hover dttables" id="dtPetaSituasi">
            <thead class="text-xs text-gray">
              <tr>
                <th>#</th>
                <th>Nama</th>
                <th>Desa</th>
                <th>Kecamatan</th>
                <th>Kabupaten</th>
                <th>Luas Tanah</th>
                <th>Status</th>
                <th></th>
              </tr>
            </thead>
            <tbody>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>

  <div class="modal fade" id="modal_prints" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-body" id="myFrame">
        </div>
      </div>
    </div>
  </div>
@endsection
