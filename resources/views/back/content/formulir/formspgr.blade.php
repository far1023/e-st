@extends('back.layouts.main')

@section('content')
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">{{ $title }}</h1>
        </div>
      </div>
    </div>
  </div>

  <div class="content">
    <div class="container-fluid">
      <div class="card">
        <div class="card-header">Buat Surat Pernyataan Ganti Rugi</div>
        <div class="card-body">
          <form id="formspgr" class="px-lg-5">
            @csrf
            {{ request()->route('id') ? method_field('PUT') : '' }}
            <div class="bs-stepper">
              <div class="bs-stepper-header d-none" role="tablist">
                <div class="step" data-target="#pihak-pertama">
                  <button type="button" class="step-trigger" role="tab" aria-controls="pihak-pertama" id="pihak-pertama-trigger">
                    <span class="bs-stepper-circle">1</span>
                    <span class="bs-stepper-label">Pihak Pertama</span>
                  </button>
                </div>
                <div class="line"></div>
                <div class="step" data-target="#pihak-kedua">
                  <button type="button" class="step-trigger" role="tab" aria-controls="pihak-kedua" id="pihak-kedua-trigger">
                    <span class="bs-stepper-circle">2</span>
                    <span class="bs-stepper-label">Pihak Kedua</span>
                  </button>
                </div>
                <div class="line"></div>
                <div class="step" data-target="#data-pendukung">
                  <button type="button" class="step-trigger" role="tab" aria-controls="data-pendukung" id="data-pendukung-trigger">
                    <span class="bs-stepper-circle">3</span>
                    <span class="bs-stepper-label">Data Pendukung</span>
                  </button>
                </div>
                <div class="line"></div>
                <div class="step" data-target="#diketahui">
                  <button type="button" class="step-trigger" role="tab" aria-controls="diketahui" id="diketahui-trigger">
                    <span class="bs-stepper-circle">4</span>
                    <span class="bs-stepper-label">Yang Mengetahui</span>
                  </button>
                </div>
              </div>
              <div class="bs-stepper-content pt-4">
                <div id="pihak-pertama" class="content" role="tabpanel" aria-labelledby="pihak-pertama-trigger">
                  <p>Yang menyatakan selanjutnya adalah <b>PIHAK PERTAMA</b></p>
                  <div class="form-group">
                    <label for="nama_pihak_pertama">Nama Lengkap</label>
                    <input type="text" class="form-control" name="nama_pihak_pertama" id="nama_pihak_pertama" placeholder="">
                    <small class="text-danger err-msg" id="nama_pihak_pertama_error"></small>
                  </div>
                  <div class="form-group">
                    <div class="row">
                      <div class="col-sm-6">
                        <label for="tempat_lahir_pihak_pertama">Tempat Lahir</label>
                        <input type="text" class="form-control" name="tempat_lahir_pihak_pertama" id="tempat_lahir_pihak_pertama" placeholder="">
                        <small class="text-danger err-msg" id="tempat_lahir_pihak_pertama_error"></small>
                      </div>
                      <div class="col-sm-6">
                        <label for="tanggal_lahir_pihak_pertama">Tanggal Lahir</label>
                        <input type="text" class="form-control datetimepicker-input" data-toggle="datetimepicker" data-target="#tanggal_lahir_pihak_pertama"
                          id="tanggal_lahir_pihak_pertama" name="tanggal_lahir_pihak_pertama" autocomplete="off">
                        <small class="text-danger err-msg" id="tanggal_lahir_pihak_pertama_error"></small>
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="wn_pihak_pertama">Warganegara</label>
                    <input type="text" class="form-control" name="wn_pihak_pertama" id="wn_pihak_pertama" placeholder="">
                    <small class="text-danger err-msg" id="wn_pihak_pertama_error"></small>
                  </div>
                  <div class="form-group">
                    <label for="ktp_pihak_pertama">No.KTP</label>
                    <input type="text" class="form-control" name="ktp_pihak_pertama" id="ktp_pihak_pertama" oninput="this.value=this.value.replace(/[^\d]/,'')">
                    <small class="text-danger err-msg" id="ktp_pihak_pertama_error"></small>
                  </div>
                  <div class="form-group">
                    <label for="alamat_pihak_pertama">Alamat</label>
                    <input type="text" class="form-control" name="alamat_pihak_pertama" id="alamat_pihak_pertama" placeholder="">
                    <small class="text-danger err-msg" id="alamat_pihak_pertama_error"></small>
                  </div>
                  <div class="pt-4">
                    <button type="button" class="btn btn-outline-primary float-right mb-3" onclick="stepper.next()">Selanjutnya <i class="las la-chevron-right"></i></button>
                  </div>
                </div>
                <div id="pihak-kedua" class="content" role="tabpanel" aria-labelledby="pihak-kedua-trigger">
                  <p>Yang memberikan ganti rugi selanjutnya adalah <b>PIHAK KEDUA</b></p>
                  <div class="form-group">
                    <label for="nama_pihak_kedua">Nama Lengkap</label>
                    <input type="text" class="form-control" name="nama_pihak_kedua" id="nama_pihak_kedua" placeholder="">
                    <small class="text-danger err-msg" id="nama_pihak_kedua_error"></small>
                  </div>
                  <div class="form-group">
                    <div class="row">
                      <div class="col-sm-6">
                        <label for="tempat_lahir_pihak_kedua">Tempat Lahir</label>
                        <input type="text" class="form-control" name="tempat_lahir_pihak_kedua" id="tempat_lahir_pihak_kedua" placeholder="">
                        <small class="text-danger err-msg" id="tempat_lahir_pihak_kedua_error"></small>
                      </div>
                      <div class="col-sm-6">
                        <label for="tanggal_lahir_pihak_kedua">Tanggal Lahir</label>
                        <input type="text" class="form-control datetimepicker-input" data-toggle="datetimepicker" data-target="#tanggal_lahir_pihak_kedua"
                          id="tanggal_lahir_pihak_kedua" name="tanggal_lahir_pihak_kedua" autocomplete="off">
                        <small class="text-danger err-msg" id="tanggal_lahir_pihak_kedua_error"></small>
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="wn_pihak_kedua">Warganegara</label>
                    <input type="text" class="form-control" name="wn_pihak_kedua" id="wn_pihak_kedua" placeholder="">
                    <small class="text-danger err-msg" id="wn_pihak_kedua_error"></small>
                  </div>
                  <div class="form-group">
                    <label for="ktp_pihak_kedua">No.KTP</label>
                    <input type="text" class="form-control" name="ktp_pihak_kedua" id="ktp_pihak_kedua" oninput="this.value=this.value.replace(/[^\d]/,'')">
                    <small class="text-danger err-msg" id="ktp_pihak_kedua_error"></small>
                  </div>
                  <div class="form-group">
                    <label for="alamat_pihak_kedua">Alamat</label>
                    <input type="text" class="form-control" name="alamat_pihak_kedua" id="alamat_pihak_kedua" placeholder="">
                    <small class="text-danger err-msg" id="alamat_pihak_kedua_error"></small>
                  </div>
                  <div class="pt-4">
                    <button type="button" class="btn btn-outline-secondary" onclick="stepper.previous()"><i class="las la-chevron-left"></i> Sebelumnya</button>
                    <button type="button" class="btn btn-outline-primary float-right mb-3" onclick="stepper.next()">Selanjutnya <i class="las la-chevron-right"></i></button>
                  </div>
                </div>
                <div id="data-pendukung" class="content" role="tabpanel" aria-labelledby="data-pendukung-trigger">
                  <div class="form-group">
                    <div class="row">
                      <div class="col-sm-10">
                        <label for="alamat_tanah">Alamat Tanah</label>
                        <input type="text" class="form-control" name="alamat_tanah" id="alamat_tanah" placeholder="">
                        <small class="text-danger err-msg" id="alamat_tanah_error"></small>
                      </div>
                      <div class="col-sm-2">
                        <label for="luas_tanah">Luas Tanah</label>
                        <div class="input-group">
                          <input type="number" min="1" class="form-control" name="luas_tanah" id="luas_tanah">
                          <div class="input-group-append">
                            <span class="input-group-text">m&#178;</span>
                          </div>
                        </div>
                        <small class="text-danger err-msg" id="luas_tanah_error"></small>
                      </div>
                    </div>
                  </div>
                  <div class="form-grup">
                    <div class="row my-4">
                      <div class="col-sm-6">
                        <label for="">Dasar Surat Tanah</label>
                        <div class="input-group">
                          <div class="input-group-prepend">
                            <span class="input-group-text">No.Reg</span>
                          </div>
                          <input type="text" class="form-control" name="no_ref" id="no_ref">
                        </div>
                        <small class="text-danger err-msg" id="no_ref_error"></small>
                      </div>
                      <div class="col-sm-6">
                        <label for="tanggal_ref">Tanggal</label>
                        <input type="text" class="form-control datetimepicker-input" data-toggle="datetimepicker" data-target="#tanggal_ref" id="tanggal_ref"
                          name="tanggal_ref" autocomplete="off">
                        <small class="text-danger err-msg" id="tanggal_ref_error"></small>
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="row">
                      <div class="col-sm-4">
                        <label for="besaran">Besaran Ganti Rugi</label>
                        <div class="input-group">
                          <div class="input-group-prepend">
                            <span class="input-group-text">Rp</span>
                          </div>
                          <input type="text" min="1" class="form-control" name="besaran" id="besaran"
                            data-inputmask="'alias': 'numeric', 'groupSeparator': '.', 'autoGroup': true, 'digits': 0, 'digitsOptional': false, 'placeholder': '0'">
                        </div>
                        <small class="text-danger err-msg" id="besaran_error"></small>
                      </div>
                      <div class="col-sm-8">
                        <label for="terbilang">Terbilang</label>
                        <input type="text" class="form-control" name="terbilang" id="terbilang">
                        <small class="text-danger err-msg" id="terbilang_error"></small>
                      </div>
                    </div>
                  </div>
                  <p class="pt-4">Batas-batas sempadan</p>
                  <div class="form-group">
                    <div class="row">
                      <div class="col-sm-5">
                        <label for="batas_utara">Batas Utara</label>
                        <input type="text" class="form-control" name="batas_utara" id="batas_utara" placeholder="">
                        <small class="text-danger err-msg" id="batas_utara_error"></small>
                      </div>
                      <div class="col-sm-2">
                        <label for="ukuran_utara">Ukuran</label>
                        <div class="input-group">
                          <input type="number" min="1" class="form-control" name="ukuran_utara" id="ukuran_utara">
                          <div class="input-group-append">
                            <span class="input-group-text">m</span>
                          </div>
                        </div>
                        <small class="text-danger err-msg" id="ukuran_utara_error"></small>
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="row">
                      <div class="col-sm-5">
                        <label for="batas_selatan">Batas Selatan</label>
                        <input type="text" class="form-control" name="batas_selatan" id="batas_selatan" placeholder="">
                        <small class="text-danger err-msg" id="batas_selatan_error"></small>
                      </div>
                      <div class="col-sm-2">
                        <label for="ukuran_selatan">Ukuran</label>
                        <div class="input-group">
                          <input type="number" min="1" class="form-control" name="ukuran_selatan" id="ukuran_selatan">
                          <div class="input-group-append">
                            <span class="input-group-text">m</span>
                          </div>
                        </div>
                        <small class="text-danger err-msg" id="ukuran_selatan_error"></small>
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="row">
                      <div class="col-sm-5">
                        <label for="batas_barat">Batas Barat</label>
                        <input type="text" class="form-control" name="batas_barat" id="batas_barat" placeholder="">
                        <small class="text-danger err-msg" id="batas_barat_error"></small>
                      </div>
                      <div class="col-sm-2">
                        <label for="ukuran_barat">Ukuran</label>
                        <div class="input-group">
                          <input type="number" min="1" class="form-control" name="ukuran_barat" id="ukuran_barat">
                          <div class="input-group-append">
                            <span class="input-group-text">m</span>
                          </div>
                        </div>
                        <small class="text-danger err-msg" id="ukuran_barat_error"></small>
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="row">
                      <div class="col-sm-5">
                        <label for="batas_timur">Batas Timur</label>
                        <input type="text" class="form-control" name="batas_timur" id="batas_timur" placeholder="">
                        <small class="text-danger err-msg" id="batas_timur_error"></small>
                      </div>
                      <div class="col-sm-2">
                        <label for="ukuran_timur">Ukuran</label>
                        <div class="input-group">
                          <input type="number" min="1" class="form-control" name="ukuran_timur" id="ukuran_timur">
                          <div class="input-group-append">
                            <span class="input-group-text">m</span>
                          </div>
                        </div>
                        <small class="text-danger err-msg" id="ukuran_timur_error"></small>
                      </div>
                    </div>
                  </div>
                  <div class="pt-4">
                    <button type="button" class="btn btn-outline-secondary" onclick="stepper.previous()"><i class="las la-chevron-left"></i> Sebelumnya</button>
                    <button type="button" class="btn btn-outline-primary float-right mb-3" onclick="stepper.next()">Selanjutnya <i class="las la-chevron-right"></i></button>
                  </div>
                </div>
                <div id="diketahui" class="content" role="tabpanel" aria-labelledby="diketahui-trigger">
                  <p>Mengetahui</p>
                  <div class="row">
                    <div class="col-sm-7">
                      <div class="form-group">
                        <div class="form-group">
                          <label for="tanggal_ref">Reg No.</label>
                          <input type="text" class="form-control" name="no_reg" id="no_reg" value="{{ $data ? $data['no_reg'] : '' }}">
                          <small class="text-danger err-msg" id="no_reg_error"></small>
                        </div>
                      </div>
                    </div>
                    <div class="col-sm-7">
                      <div class="form-group">
                        <label for="tanggal_reg">Tanggal</label>
                        <input type="text" class="form-control datetimepicker-input" data-toggle="datetimepicker" data-target="#tanggal_reg" id="tanggal_reg"
                          name="tanggal_reg" autocomplete="off">
                        <small class="text-danger err-msg" id="tanggal_reg_error"></small>
                      </div>
                    </div>
                    <div class="col-sm-7">
                      <div class="form-group">
                        <label for="mengetahui">Kepala Desa Air Putih</label>
                        <input type="text" class="form-control" name="mengetahui" id="mengetahui" value="{{ $data ? $data['kades'] : '' }}">
                        <small class="text-danger err-msg" id="mengetahui_error"></small>
                      </div>
                    </div>
                  </div>
                  <div class="pt-4">
                    <button type="button" class="btn btn-outline-secondary" onclick="stepper.previous()"><i class="las la-chevron-left"></i> Sebelumnya</button>
                    <button type="submit" class="btn btn-primary float-right px-4" id="btn-save">Simpan data</button>
                  </div>
                </div>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
@endsection
