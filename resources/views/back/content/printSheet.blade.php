@extends('back.layouts.main')

@section('content')
  <div class="content">
    <div class="container-fluid">
      <div class="py-4 row justify-content-center">
        @if (Auth::user()->can('print-out') && $data['result']['checked_at'] && $data['result']['approved_at'])
          <div class="col-lg-1 d-block d-lg-none">
            <button class="btn btn-block btn-default mb-3 print"><i class="las la-print"></i>&nbsp; Cetak</button>
          </div>
        @endif
        <div class="col-lg-11">
          @if (!$data['result']['checked_at'] && !$data['result']['approved_at'])
            <div class="callout callout-warning">
              <p>Berkas hanya dapat dicetak setelah mendapat persetujuan dari Sekdes dan Kades</p>
            </div>
          @endif
          <div class="card" style="text-align: justify; text-justify: inter-word;">
            <div class="card-body pb-5" id="printMe">
            </div>
          </div>
        </div>
        @if (Auth::user()->can('print-out') && $data['result']['checked_at'] && $data['result']['approved_at'])
          <div class="col-lg-1 d-none d-lg-block">
            <button class="btn btn-default p-3 text-center print"><i class="las la-print la-2x"></i><br>Cetak</button>
          </div>
        @endif
      </div>
    </div>
  </div>
@endsection
