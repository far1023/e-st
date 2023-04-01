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
        <div class="card-header text-center">Sceets Kaartsceests Kaart</div>
        <div class="card-body">
          <form id="formpetasituasi" class="px-lg-5">
            <div id="load"></div>
            @csrf
            {{ request()->route('id') ? method_field('PUT') : '' }}
            <div class="bs-stepper">
              <div class="bs-stepper-header d-none" role="tablist">
                <div class="step" data-target="#data-tanah">
                  <button type="button" class="step-trigger" role="tab" aria-controls="data-tanah" id="data-tanah-trigger">
                    <span class="bs-stepper-circle">1</span>
                    <span class="bs-stepper-label">Pihak Pertama</span>
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
                    <label for="atas_nama">Atas Nama</label> <small><i>(yang membuat pernyataan)</i></small>
                    <input type="text" class="form-control" name="atas_nama" id="atas_nama" placeholder="">
                    <small class="text-danger err-msg" id="atas_nama_error"></small>
                  </div>
                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="keterangan">Keterangan</label>
                        <input type="text" class="form-control" name="keterangan" id="keterangan" placeholder="">
                        <small class="text-danger err-msg" id="keterangan_error"></small>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="pihak_kedua">Pihak lain</label>
                        <input type="text" class="form-control" name="pihak_kedua" id="pihak_kedua" placeholder="">
                        <small class="text-danger err-msg" id="pihak_kedua_error"></small>
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="sketsa">Sketsa</label>
                    <input type="text" class="form-control" name="sketsa" id="sketsa" placeholder="">
                    <small class="text-danger err-msg" id="sketsa_error"></small>
                  </div>
                  <div class="pt-4">
                    <button type="button" class="btn btn-outline-secondary" onclick="stepper.previous()"><i class="las la-chevron-left"></i> Sebelumnya</button>
                    <button type="button" class="btn btn-outline-primary float-right mb-3" onclick="stepper.next()">Selanjutnya <i class="las la-chevron-right"></i></button>
                  </div>
                </div>
                <div id="diketahui" class="content" role="tabpanel" aria-labelledby="diketahui-trigger">
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
