<h6 class="text-center text-uppercase font-weight-bold">
  SCEETS KAARTSCEETS KAART<br>
  ( PETA SITUASI TANAH )
</h6>
<p>
  Sebagian tanah yang akan ditetapkan status haknya oleh
  <br>
  Badan Pertanahan Nasional yang terletak di :
</p>
<table>
  <tr>
    <td>Jalan/Gang</td>
    <td>&emsp; : &emsp;</td>
    <td>{{ $data['jalan_gang'] }}</td>
  </tr>
  <tr>
    <td>&emsp; RT/RW</td>
    <td>&emsp; : &emsp;</td>
    <td>{{ $data['rt'] }}/{{ $data['rw'] }}</td>
  </tr>
  <tr>
    <td>Desa</td>
    <td>&emsp; : &emsp;</td>
    <td>{{ $data['desa'] }}</td>
  </tr>
  <tr>
    <td>Kecamatan</td>
    <td>&emsp; : &emsp;</td>
    <td>{{ $data['kecamatan'] }}</td>
  </tr>
  <tr>
    <td>Kabupaten</td>
    <td>&emsp; : &emsp;</td>
    <td>{{ $data['kabupaten'] }}</td>
  </tr>
  <tr>
    <td>Luas Tanah</td>
    <td>&emsp; : &emsp;</td>
    <td><b>&pm; {{ $data['luas_tanah'] }} m&sup2;</b></td>
  </tr>
  <tr>
    <td>Atas Nama</td>
    <td>&emsp; : &emsp;</td>
    <td><b>{{ $data['atas_nama'] }}</b> {{ $data['keterangan'] ? $data['keterangan'] : '' }}
      {!! $data['pihak_kedua'] ? 'kepada <b>' . $data['pihak_kedua'] . '</b>' : '' !!}</td>
  </tr>
</table>
<div class="py-4 text-center" style="min-height: 500px; max-height: 600px">
  @if ($data['sketsa'])
    <img src="{{ asset('storage/' . $data['sketsa']) }}" alt="Sketsa" style="max-height: 550px;">
  @endif
</div>
<table style="width: 100%">
  <tr>
    <td style="width: 50%"></td>
    <td style="width: 50%; text-align: center;">Air Putih, {{ Carbon\Carbon::parse($data['created_at'])->isoFormat('D MMMM Y') }}</td>
  </tr>
  <tr>
    <td style="width: 50%; text-align: center;"></td>
    <td style="width: 50%; text-align: center;">Yang membuat pernyataan</td>
  </tr>
  <tr>
    <td style="width: 50%; text-align: center; padding-top: 3rem"></td>
    <td style="width: 50%; text-align: center; padding-top: 3rem"><b>{{ $data['atas_nama'] }}</b></td>
  </tr>
</table>
<br>
<div class="text-center pt-3">
  <span>Mengetahui:</span>
  <div class="row justify-content-center">
    @if ($data['jabatan_saksi_satu'])
      <div class="col-4">
        {{ $data['jabatan_saksi_satu'] }}
        <p class="pt-5 font-weight-bold">
          {{ $data['nama_saksi_satu'] }}
        </p>
      </div>
    @endif
    @if ($data['jabatan_saksi_dua'])
      <div class="col-4">
        {{ $data['jabatan_saksi_dua'] }}
        <p class="pt-5 font-weight-bold">
          {{ $data['nama_saksi_dua'] }}
        </p>
      </div>
    @endif
    @if ($data['jabatan_saksi_tiga'])
      <div class="col-4">
        {{ $data['jabatan_saksi_tiga'] }}
        <p class="pt-5 font-weight-bold">
          {{ $data['nama_saksi_tiga'] }}
        </p>
      </div>
    @endif
  </div>
  <div class="ml-5 pl-5 pt-3">
    <span>Mengetahui:</span><br>
    <span>KEPALA DESA AIR PUTIH</span>
    <p class="pt-5 font-weight-bold">{{ $data['mengetahui'] }}</p>
  </div>
</div>
