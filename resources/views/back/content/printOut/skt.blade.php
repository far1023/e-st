<h6 class="text-center text-uppercase font-weight-bold">
  SURAT PERNYATAAN PEMILIKAN/PENGUASAAN TANAH,<br>
  PERNYATAAN TIDAK BERSENGKETA<br>
  DAN SURAT PERNYATAAN SAKSI SEMPADAN
</h6>
<span>Yang bertanda tangan di bawah ini:</span>
<table>
  <tr>
    <td>&nbsp; &emsp;</td>
    <td>Nama</td>
    <td>&nbsp; : &nbsp;</td>
    <td><b>{{ Str::upper($data['nama_pemilik']) }}</b></td>
  </tr>
  <tr>
    <td></td>
    <td>Tempat tanggal lahir</td>
    <td>&nbsp; : &nbsp;</td>
    <td>{{ $data['tempat_lahir_pemilik'] }}, {{ \Carbon\Carbon::parse($data['tanggal_lahir_pemilik'])->isoFormat('D MMMM Y') }}</td>
  </tr>
  <tr>
    <td></td>
    <td>Warganegara</td>
    <td>&nbsp; : &nbsp;</td>
    <td>{{ $data['wn_pemilik'] }}</td>
  </tr>
  <tr>
    <td></td>
    <td>No KTP</td>
    <td>&nbsp; : &nbsp;</td>
    <td>{{ $data['ktp_pemilik'] }}</td>
  </tr>
  <tr>
    <td></td>
    <td>Alamat</td>
    <td>&nbsp; : &nbsp;</td>
    <td>{{ $data['alamat_pemilik'] }}</td>
  </tr>
</table>
<br>
<span>Dengan akal dan fikiran yang sehat serta tidak dipengaruhi oleh siapapun juga, menyatakan dengan sesungguhnya bahwa saya adalah yang menguasai sebagian tanah yang
  terletak di :</span>
<table>
  <tr>
    <td>Jalan/Gang</td>
    <td>&emsp; : &emsp;</td>
    <td>{{ $data['jalan_gang'] }}</td>
    <td>&emsp; &emsp;</td>
    <td>RT/RW</td>
    <td>&nbsp; : &nbsp;</td>
    <td>{{ $data['rt'] }}/{{ $data['rw'] }}</td>
  </tr>
  <tr>
    <td>Dusun</td>
    <td>&emsp; : &emsp;</td>
    <td>{{ $data['dusun'] }}</td>
    <td>&emsp; &emsp;</td>
    <td>Desa</td>
    <td>&nbsp; : &nbsp;</td>
    <td>{{ $data['desa'] }}</td>
  </tr>
  <tr>
    <td>Kecamatan</td>
    <td>&emsp; : &emsp;</td>
    <td>{{ $data['kecamatan'] }}</td>
    <td>&emsp; &emsp;</td>
    <td>Kabupaten</td>
    <td>&nbsp; : &nbsp;</td>
    <td>{{ $data['kabupaten'] }}</td>
  </tr>
  <tr>
    <td>SPPT PBB NO</td>
    <td>&emsp; : &emsp;</td>
    <td colspan="5">{{ $data['pbb'] }}</td>
  </tr>
  <tr>
    <td>Luas Tanah</td>
    <td>&emsp; : &emsp;</td>
    <td colspan="5"><b>&pm; {{ $data['luas_tanah'] }} m&sup2;</b></td>
  </tr>
  <tr>
    <td>Tanah tersebut saya peroleh dari</td>
    <td>&emsp; : &emsp;</td>
    <td colspan="5"><b>{{ $data['peroleh_dari'] }}</b></td>
  </tr>
  <tr>
    <td>Jenis tanaman keras yaitu</td>
    <td>&emsp; : &emsp;</td>
    <td colspan="5">{{ $data['tanaman_keras'] }}</td>
  </tr>
  <tr>
    <td>Dasar Surat Tanah</td>
    <td>&emsp; : &emsp;</td>
    <td colspan="5">SPGR Nomor. {{ $data['no_ref'] }}, Tanggal {{ Carbon\Carbon::parse($data['tanggal_ref'])->isoFormat('D MMMM Y') }}</td>
  </tr>
</table>
<br>
<span>Dengan batas-batas tanah sebagai berikut :</span>
<table>
  <tr>
    <td>Sebelah Utara berbasatan dengan Tanah {{ $data['batas_utara'] }}</td>
    <td>&emsp; : &nbsp;</td>
    <td>Ukuran {{ $data['ukuran_utara'] }}m</td>
  </tr>
  <tr>
    <td>Sebelah Selatan berbasatan dengan Tanah {{ $data['batas_selatan'] }}</td>
    <td>&emsp; : &nbsp;</td>
    <td>Ukuran {{ $data['ukuran_selatan'] }}m</td>
  </tr>
  <tr>
    <td>Sebelah Barat berbasatan dengan Tanah {{ $data['batas_barat'] }}</td>
    <td>&emsp; : &nbsp;</td>
    <td>Ukuran {{ $data['ukuran_barat'] }}m</td>
  </tr>
  <tr>
    <td>Sebelah Timur berbasatan dengan Tanah {{ $data['batas_timur'] }}</td>
    <td>&emsp; : &nbsp;</td>
    <td>Ukuran {{ $data['ukuran_timur'] }}m</td>
  </tr>
</table>
<br>
<p>Tanah tersebut bukan Hutan Negara atau Hutan Bakau, selama saya menguasai tanah tersebut tidak pernah terjadi persengketaan dengan batas orang lain maupun sitaan
  keridit Perbankan/Hipotik digadaikan dan berupa lainnya serta tidak berada dalam kawasan hak penguasaan Hutan dan Tanah milik Badan Usaha atau Badan Hukum lainnya dan
  bukan merupakan kawasan Hutan Negara, kawasan Hutan Lindung dan suaka marga satwa
  <br>
  Jika dikemudian hari terdapat permasalahan/persengketaan atas Tanah tersebut, saya tidak akan melibatkan Pihak Pemerintah atau Camat serta Kepala Desa, semua
  permasalahan akan saya selesaikan sendiri sesuai dengan Hukum dan Peraturan dan Perundang-undangan yang berlaku ini semua menjadi tanggung jawab saya sepenuhnya.
  <br>
  Demikian surat pernyataan ini saya buat dengan sebenar-benarnya dan tanpa ada paksaan dari Pihak Manapun juga.
</p>
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
    <td style="width: 50%; text-align: center; padding-top: 3rem"><b>{{ $data['nama_pemilik'] }}</b></td>
  </tr>
</table>
<br>
<p>Surat pernyataan ini dibuat di hadapan saksi sempadan yang membernarkan pernyataan di atas dan turut menandatangani, yaitu :</p>
<div class="row">
  <div class="col-5">
    <table>
      <tr>
        <td class="pt-4">1. &nbsp;</td>
        <td class="pt-4">{{ $data['batas_utara'] }}</td>
        <td class="pt-4">&emsp; ( . . . . . . . . . . . . . . . . . )</td>
      </tr>
      <tr>
        <td class="pt-4">2. &nbsp;</td>
        <td class="pt-4">{{ $data['batas_selatan'] }}</td>
        <td class="pt-4">&emsp; ( . . . . . . . . . . . . . . . . . )</td>
      </tr>
      <tr>
        <td class="pt-4">3. &nbsp;</td>
        <td class="pt-4">{{ $data['batas_barat'] }}</td>
        <td class="pt-4">&emsp; ( . . . . . . . . . . . . . . . . . )</td>
      </tr>
      <tr>
        <td class="pt-4">4. &nbsp;</td>
        <td class="pt-4">{{ $data['batas_timur'] }}</td>
        <td class="pt-4">&emsp; ( . . . . . . . . . . . . . . . . . )</td>
      </tr>
    </table>
  </div>
  <div class="col-7 text-center">
    <span>SAKSI - SAKSI</span>
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
    <span>Mengetahui:</span><br>
    <span>KEPALA DESA AIR PUTIH</span>
    <p class="pt-5 font-weight-bold">{{ $data['mengetahui'] }}</p>
  </div>
</div>
