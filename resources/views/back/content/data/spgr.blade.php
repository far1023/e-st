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
            <li class="breadcrumb-item active">Pernyataan Ganti Rugi</li>
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
            <a href="{{ url('formulir/ganti-rugi') }}" class="btn btn-sm btn-outline-primary float-right px-3">
              <i class="fa fa-fw fa-plus"></i> Pengajuan Baru
            </a>
          </div>
          <table class="table table-striped table-hover dttables" id="dt_spgr">
            <thead>
              <tr>
                <th style="text-align: center;">#</th>
                <th style="text-align: center;">No.Reg</th>
                <th style="text-align: center;">NIK</th>
                <th style="text-align: center;">Pihak Pertama</th>
                <th style="text-align: center;">TTL</th>
                <th style="text-align: center;">Warganegara</th>
                <th style="text-align: center;">Alamat</th>
                <th style="text-align: center;">Aksi</th>
              </tr>
            </thead>
            <tbody>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
@endsection
