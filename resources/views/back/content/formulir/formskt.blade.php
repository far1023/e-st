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
        <div class="card-header text-center px-lg-5">
          SURAT PERNYATAAN PEMILIKAN/PENGUASAAN TANAH, PERNYATAAN TIDAK BERSENGKETA DAN SURAT PERNYATAAN SAKSI SEMPADAN
        </div>
        <div class="card-body">
          <form id="formskt" class="px-lg-5">
            <div id="load"></div>
            @csrf
            {{ request()->route('id') ? method_field('PUT') : '' }}
            <div class="bs-stepper">
              <div class="bs-stepper-header d-none" role="tablist">
                <div class="step" data-target="#data-pemilik">
                  <button type="button" class="step-trigger" role="tab" aria-controls="data-pemilik" id="data-pemilik-trigger">
                    <span class="bs-stepper-circle">1</span>
                    <span class="bs-stepper-label">Data Pemilik</span>
                  </button>
                </div>
                <div class="line"></div>
                <div class="step" data-target="#data-tanah">
                  <button type="button" class="step-trigger" role="tab" aria-controls="data-tanah" id="data-tanah-trigger">
                    <span class="bs-stepper-circle">2</span>
                    <span class="bs-stepper-label">Data Tanah</span>
                  </button>
                </div>
                <div class="line"></div>
                <div class="step" data-target="#data-sempadan">
                  <button type="button" class="step-trigger" role="tab" aria-controls="data-sempadan" id="data-sempadan-trigger">
                    <span class="bs-stepper-circle">3</span>
                    <span class="bs-stepper-label">Data Saksi Sempadan</span>
                  </button>
                </div>
                <div class="line"></div>
                <div class="step" data-target="#data-saksi">
                  <button type="button" class="step-trigger" role="tab" aria-controls="data-saksi" id="data-saksi-trigger">
                    <span class="bs-stepper-circle">4</span>
                    <span class="bs-stepper-label">Diketahui</span>
                  </button>
                </div>
              </div>
              <div class="bs-stepper-content pt-4">
                <div id="data-pemilik" class="content" role="tabpanel" aria-labelledby="data-pemilik-trigger">
                  <p>Saya yang bertanda tangan di bawah ini :</p>
                  <div class="form-group">
                    <label for="nama_pemilik">Nama Lengkap</label> <small><i>(yang membuat pernyataan)</i></small>
                    <input type="text" class="form-control" name="nama_pemilik" id="nama_pemilik" placeholder="">
                    <small class="text-danger err-msg" id="nama_pemilik_error"></small>
                  </div>
                  <div class="form-group">
                    <label for="tempat_lahir_pemilik">Tempat Lahir</label>
                    <input type="text" class="form-control" name="tempat_lahir_pemilik" id="tempat_lahir_pemilik" placeholder="">
                    <small class="text-danger err-msg" id="tempat_lahir_pemilik_error"></small>
                  </div>
                  <div class="form-group">
                    <label for="tanggal_lahir_pemilik">Tanggal Lahir</label>
                    <input type="text" class="form-control datetimepicker-input" data-toggle="datetimepicker" data-target="#tanggal_lahir_pemilik" id="tanggal_lahir_pemilik"
                      name="tanggal_lahir_pemilik" autocomplete="off">
                    <small class="text-danger err-msg" id="tanggal_lahir_pemilik_error"></small>
                  </div>
                  <div class="form-group">
                    <label for="wn_pemilik">Warganegara</label>
                    <input type="text" class="form-control" name="wn_pemilik" id="wn_pemilik" placeholder="">
                    <small class="text-danger err-msg" id="wn_pemilik_error"></small>
                  </div>
                  <div class="form-group">
                    <label for="ktp_pemilik">No.KTP</label>
                    <input type="text" class="form-control" name="ktp_pemilik" id="ktp_pemilik" oninput="this.value=this.value.replace(/[^\d]/,'')">
                    <small class="text-danger err-msg" id="ktp_pemilik_error"></small>
                  </div>
                  <div class="form-group">
                    <label for="alamat_pemilik">Alamat</label>
                    <input type="text" class="form-control" name="alamat_pemilik" id="alamat_pemilik" placeholder="">
                    <small class="text-danger err-msg" id="alamat_pemilik_error"></small>
                  </div>
                  <div class="pt-4">
                    <button type="button" class="btn btn-outline-primary float-right mb-3" onclick="stepper.next()">Selanjutnya <i class="las la-chevron-right"></i></button>
                  </div>
                </div>
                <div id="data-tanah" class="content" role="tabpanel" aria-labelledby="data-tanah-trigger">
                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="jalan_gang">Jalan / Gang</label>
                        <input type="text" class="form-control" name="jalan_gang" id="jalan_gang" placeholder="">
                        <small class="text-danger err-msg" id="jalan_gang_error"></small>
                      </div>
                    </div>
                    <div class="col-md-3">
                      <div class="form-group">
                        <label for="rt">RT</label>
                        <input type="text" class="form-control" name="rt" id="rt" oninput="this.value=this.value.replace(/[^\d]/,'')">
                        <small class="text-danger err-msg" id="rt_error"></small>
                      </div>
                    </div>
                    <div class="col-md-3">
                      <div class="form-group">
                        <label for="rw">RW</label>
                        <input type="text" class="form-control" name="rw" id="rw" oninput="this.value=this.value.replace(/[^\d]/,'')">
                        <small class="text-danger err-msg" id="rw_error"></small>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="dusun">Nama Dusun</label>
                        <input type="text" class="form-control" name="dusun" id="dusun" placeholder="">
                        <small class="text-danger err-msg" id="dusun_error"></small>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="desa">Nama Desa</label>
                        <input type="text" class="form-control" name="desa" id="desa" placeholder="">
                        <small class="text-danger err-msg" id="desa_error"></small>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="kecamatan">Kecamatan</label>
                        <input type="text" class="form-control" name="kecamatan" id="kecamatan" placeholder="">
                        <small class="text-danger err-msg" id="kecamatan_error"></small>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="kabupaten">Kabupaten</label>
                        <input type="text" class="form-control" name="kabupaten" id="kabupaten" placeholder="">
                        <small class="text-danger err-msg" id="kabupaten_error"></small>
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="pbb">No. SPPT PBB</label>
                    <input type="text" class="form-control" name="pbb" id="pbb" placeholder="">
                    <small class="text-danger err-msg" id="pbb_error"></small>
                  </div>
                  <div class="form-group">
                    <label for="luas_tanah">Luas Tanah</label>
                    <div class="input-group">
                      <input type="number" min="1" class="form-control" name="luas_tanah" id="luas_tanah">
                      <div class="input-group-append">
                        <span class="input-group-text">m&#178;</span>
                      </div>
                    </div>
                    <small class="text-danger err-msg" id="luas_tanah_error"></small>
                  </div>
                  <div class="form-group">
                    <label for="peroleh_dari">Tanah Diperoleh Dari</label>
                    <input type="text" class="form-control" name="peroleh_dari" id="peroleh_dari" placeholder="">
                    <small class="text-danger err-msg" id="peroleh_dari_error"></small>
                  </div>
                  <div class="form-group">
                    <label for="tanaman_keras">Jenis Tanaman Keras Yaitu</label>
                    <input type="text" class="form-control" name="tanaman_keras" id="tanaman_keras" placeholder="">
                    <small class="text-danger err-msg" id="tanaman_keras_error"></small>
                  </div>
                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="no_ref">Dasar Surat Tanah</label>
                        <input type="text" class="form-control" name="no_ref" id="no_ref" placeholder="">
                        <small class="text-danger err-msg" id="no_ref_error"></small>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="tanggal_ref">Tanggal</label>
                        <input type="text" class="form-control datetimepicker-input" data-toggle="datetimepicker" data-target="#tanggal_ref" id="tanggal_ref"
                          name="tanggal_ref" autocomplete="off">
                        <small class="text-danger err-msg" id="tanggal_ref_error"></small>
                      </div>
                    </div>
                  </div>
                  <div class="pt-4">
                    <button type="button" class="btn btn-outline-secondary" onclick="stepper.previous()"><i class="las la-chevron-left"></i> Sebelumnya</button>
                    <button type="button" class="btn btn-outline-primary float-right mb-3" onclick="stepper.next()">Selanjutnya <i class="las la-chevron-right"></i></button>
                  </div>
                </div>
                <div id="data-sempadan" class="content" role="tabpanel" aria-labelledby="data-sempadan-trigger">
                  <p>Saksi dan batas sempadan :</p>
                  <div class="row">
                    <div class="col-sm-5">
                      <div class="form-group">
                        <label for="batas_utara">Batas Utara</label>
                        <input type="text" class="form-control" name="batas_utara" id="batas_utara" placeholder="">
                        <small class="text-danger err-msg" id="batas_utara_error"></small>
                      </div>
                    </div>
                    <div class="col-sm-2">
                      <div class="form-group">
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
                  <div class="row">
                    <div class="col-sm-5">
                      <div class="form-group">
                        <label for="batas_selatan">Batas Selatan</label>
                        <input type="text" class="form-control" name="batas_selatan" id="batas_selatan" placeholder="">
                        <small class="text-danger err-msg" id="batas_selatan_error"></small>
                      </div>
                    </div>
                    <div class="col-sm-2">
                      <div class="form-group">
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
                  <div class="row">
                    <div class="col-sm-5">
                      <div class="form-group">
                        <label for="batas_barat">Batas Barat</label>
                        <input type="text" class="form-control" name="batas_barat" id="batas_barat" placeholder="">
                        <small class="text-danger err-msg" id="batas_barat_error"></small>
                      </div>
                    </div>
                    <div class="col-sm-2">
                      <div class="form-group">
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
                  <div class="row">
                    <div class="col-sm-5">
                      <div class="form-group">
                        <label for="batas_timur">Batas Timur</label>
                        <input type="text" class="form-control" name="batas_timur" id="batas_timur" placeholder="">
                        <small class="text-danger err-msg" id="batas_timur_error"></small>
                      </div>
                    </div>
                    <div class="col-sm-2">
                      <div class="form-group">
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
                <div id="data-saksi" class="content" role="tabpanel" aria-labelledby="data-saksi-trigger">
                  <p>Yang menjadi saksi :</p>
                  <div class="row">
                    <div class="col-sm-6">
                      <div class="form-group">
                        <label for="nama_saksi_satu">Nama Saksi Satu</label>
                        <input type="text" class="form-control" name="nama_saksi_satu" id="nama_saksi_satu" placeholder="">
                        <small class="text-danger err-msg" id="nama_saksi_satu_error"></small>
                      </div>
                    </div>
                    <div class="col-sm-6">
                      <div class="form-group">
                        <label for="jabatan_saksi_satu">Jabatan Saksi Satu</label>
                        <input type="text" class="form-control" name="jabatan_saksi_satu" id="jabatan_saksi_satu" placeholder="">
                        <small class="text-danger err-msg" id="jabatan_saksi_satu_error"></small>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-sm-6">
                      <div class="form-group">
                        <label for="nama_saksi_dua">Nama Saksi Dua</label>
                        <input type="text" class="form-control" name="nama_saksi_dua" id="nama_saksi_dua" placeholder="">
                        <small class="text-danger err-msg" id="nama_saksi_dua_error"></small>
                      </div>
                    </div>
                    <div class="col-sm-6">
                      <div class="form-group">
                        <label for="jabatan_saksi_dua">Jabatan Saksi Dua</label>
                        <input type="text" class="form-control" name="jabatan_saksi_dua" id="jabatan_saksi_dua" placeholder="">
                        <small class="text-danger err-msg" id="jabatan_saksi_dua_error"></small>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-sm-6">
                      <div class="form-group">
                        <label for="nama_saksi_tiga">Nama Saksi Tiga</label>
                        <input type="text" class="form-control" name="nama_saksi_tiga" id="nama_saksi_tiga" placeholder="">
                        <small class="text-danger err-msg" id="nama_saksi_tiga_error"></small>
                      </div>
                    </div>
                    <div class="col-sm-6">
                      <div class="form-group">
                        <label for="jabatan_saksi_tiga">Jabatan Saksi Tiga</label>
                        <input type="text" class="form-control" name="jabatan_saksi_tiga" id="jabatan_saksi_tiga" placeholder="">
                        <small class="text-danger err-msg" id="jabatan_saksi_tiga_error"></small>
                      </div>
                    </div>
                  </div>
                  <p class="pt-4">Yang mengetahui :</p>
                  <div class="form-group">
                    <label for="mengetahui">Kepala Desa Air Putih</label>
                    <input type="text" class="form-control" name="mengetahui" id="mengetahui" value="{{ $data ? $data['kades'] : '' }}">
                    <small class="text-danger err-msg" id="mengetahui_error"></small>
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
