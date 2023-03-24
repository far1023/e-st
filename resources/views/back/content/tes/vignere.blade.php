@extends('back.layouts.main')

@section('content')
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Vignere Cipher</h1>
        </div>
      </div>
    </div>
  </div>

  <div class="content">
    <div class="container-fluid">
      <div class="row justify-content-center">
        <div class="col-md-7 p-md-2 mb-3">
          <textarea class="form-control" name="text" id="text" rows="5" style="resize: none;"></textarea>
          <small class="text-danger err-msg" id="text_error"></small>
        </div>
        <div class="col-md-7 px-xl-4 p-md-2">
          <div class="row">
            <div class="col-12">
              <div class="input-group">
                <div class="input-group-prepend">
                  <div class="input-group-text">
                    <span class="las la-key"></span>
                  </div>
                </div>
                <input type="text" name="key" id="key" value="{{ env('VIGNERE_KEY') }}" class="form-control" placeholder="Key">
              </div>
              <small class="text-danger err-msg" id="key_error"></small>
            </div>
          </div>
          <div class="row mb-4">
            <div class="col-12 col-sm-6 mt-2">
              <button type="button" class="btn btn-sm btn-block btn-outline-primary vignere" data-method="Encrypt" id="encrypt">Encrypt</button>
            </div>
            <div class="col-12 col-sm-6 mt-2">
              <button type="button" class="btn btn-sm btn-block btn-outline-info vignere" data-method="Decrypt" id="decrypt">Decrypt</button>
            </div>
          </div>
        </div>
        <div class="col-md-7 p-md-2">
          <label for="result">RESULT</label>
          <textarea class="form-control bg-white" name="result" id="result" rows="5" style="resize: none;" disabled></textarea>
        </div>
      </div>
    </div>
  </div>
@endsection
