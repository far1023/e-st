@extends('back.layouts.main')

@section('content')
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Starter Page</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">Starter Page</li>
          </ol>
        </div>
      </div>
    </div>
  </div>

  <div class="content">
    <div class="container-fluid">
      <div class="row justify-content-center">
        <div class="col-xl-5 col-md-6 pr-xl-4 py-xl-3 p-md-2">
          <a href="{{ url('data/ganti-rugi') }}" class="info-box bg-default text-dark">
            <span class="info-box-icon"><i class="las la-hand-holding-usd la-lg"></i></span>
            <div class="info-box-content">
              <span class="info-box-text">Pernyataan Ganti Rugi</span>
              <h4 class="info-box-number">{{ $all['spgr'] }}</h4>
              <div class="progress bg-info">
                <div class="progress-bar" style="width: {{ $all['spgr'] > 0 ? ($need_approval['spgr'] / $all['spgr']) * 100 : 0 }}%; background-color: #D0D0D0"></div>
              </div>
              <span class="progress-description">
                @if ($need_approval['spgr'] > 0)
                  {{ $need_approval['spgr'] }} belum disetujui
                @else
                  &emsp;
                @endif
              </span>
            </div>
          </a>
        </div>

        <div class="col-xl-5 col-md-6 pr-xl-4 py-xl-3 p-md-2">
          <a href="{{ url('data/kepemilikan-tanah') }}" class="info-box bg-default text-dark">
            <span class="info-box-icon"><i class="las la-certificate la-lg"></i></span>
            <div class="info-box-content">
              <span class="info-box-text">Surat Kepemilikan Tanah</span>
              <h4 class="info-box-number">{{ $all['skt'] }}</h4>
              <div class="progress bg-info">
                <div class="progress-bar" style="width: {{ $all['skt'] > 0 ? ($need_approval['skt'] / $all['skt']) * 100 : 0 }}%; background-color: #D0D0D0"></div>
              </div>
              <span class="progress-description">
                @if ($need_approval['skt'] > 0)
                  {{ $need_approval['skt'] }} belum disetujui
                @else
                  &emsp;
                @endif
              </span>
            </div>
          </a>
        </div>

        <div class="col-xl-5 col-md-6 pr-xl-4 py-xl-3 p-md-2">
          <a href="{{ url('data/peta-situasi-tanah') }}" class="info-box bg-default text-dark">
            <span class="info-box-icon"><i class="las la-map la-lg"></i></span>
            <div class="info-box-content">
              <span class="info-box-text">Peta Situasi Tanah</span>
              <h4 class="info-box-number">{{ $all['peta_situasi'] }}</h4>
              <div class="progress bg-info">
                <div class="progress-bar"
                  style="width: {{ $all['peta_situasi'] > 0 ? ($need_approval['peta_situasi'] / $all['peta_situasi']) * 100 : 0 }}%; background-color: #D0D0D0"></div>
              </div>
              <span class="progress-description">
                @if ($need_approval['peta_situasi'] > 0)
                  {{ $need_approval['peta_situasi'] }} belum disetujui
                @else
                  &emsp;
                @endif
              </span>
            </div>
          </a>
        </div>

        <div class="col-xl-5 col-md-6 pr-xl-4 py-xl-3 p-md-2">
          <a href="{{ url('data/surat-situasi-tanah') }}" class="info-box bg-default text-dark">
            <span class="info-box-icon"><i class="las la-map-signs la-lg"></i></span>
            <div class="info-box-content">
              <span class="info-box-text">Surat Situasi Tanah</span>
              <h4 class="info-box-number">{{ $all['surat_situasi'] }}</h4>
              <div class="progress bg-info">
                <div class="progress-bar"
                  style="width: {{ $all['surat_situasi'] > 0 ? ($need_approval['surat_situasi'] / $all['surat_situasi']) * 100 : 0 }}%; background-color: #D0D0D0"></div>
              </div>
              <span class="progress-description">
                @if ($need_approval['surat_situasi'] > 0)
                  {{ $need_approval['surat_situasi'] }} belum disetujui
                @else
                  &emsp;
                @endif
              </span>
            </div>
          </a>
        </div>
      </div>
    </div>
  </div>
@endsection
