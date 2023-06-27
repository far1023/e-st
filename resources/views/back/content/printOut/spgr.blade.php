<h6 class="text-center text-uppercase font-weight-bold"><u>SURAT PERNYATAAN GANTI RUGI</u></h6>
<span>Yang bertanda tangan :</span>
<table>
  <tr>
    <td>1.&emsp;</td>
    <td>Nama</td>
    <td>&nbsp; : &nbsp;</td>
    <td><b>{{ Str::upper($data['nama_pihak_pertama']) }}</b></td>
  </tr>
  <tr>
    <td></td>
    <td>Tempat tanggal lahir</td>
    <td>&nbsp; : &nbsp;</td>
    <td>{{ $data['tempat_lahir_pihak_pertama'] }}, {{ \Carbon\Carbon::parse($data['tanggal_lahir_pihak_pertama'])->isoFormat('D MMMM Y') }}</td>
  </tr>
  <tr>
    <td></td>
    <td>Warganegara</td>
    <td>&nbsp; : &nbsp;</td>
    <td>{{ $data['wn_pihak_pertama'] }}</td>
  </tr>
  <tr>
    <td></td>
    <td>No KTP</td>
    <td>&nbsp; : &nbsp;</td>
    <td>{{ $data['ktp_pihak_pertama'] }}</td>
  </tr>
  <tr>
    <td></td>
    <td>Alamat</td>
    <td>&nbsp; : &nbsp;</td>
    <td>{{ $data['alamat_pihak_pertama'] }}</td>
  </tr>
</table>
<br>
<p>
  Dalam Surat Pernyataan Ganti Rugi ini bertindak atas nama diri sendiri <b>{{ Str::upper($data['nama_pihak_pertama']) }}</b> pemilik sebidang tanah yang
  terletak di
  {{ $data['alamat_tanah'] }}
  @if ($data['no_ref'] && $data['tanggal_ref'])
    yang dikuasai berdasarkan Surat Pernyataan Ganti Rugi Nomor {{ $data['no_ref'] }} Tanggal
    {{ \Carbon\Carbon::parse($data['tanggal_ref'])->isoFormat('D MMMM Y') }}
  @endif
  dengan luas Tanah &pm; <b>{{ $data['luas_tanah'] }} m&sup2;</b> dipergunakan untuk <b>{{ Str::upper($data['pergunaan_tanah']) }}</b> adapun tanah
  tersebut dengan
  batas-batas sempadan sebagai berikut :
</p>
<table>
  <tr>
    <td>Sebelah Utara berbasatan dengan {{ $data['batas_utara'] }}</td>
    <td>&emsp; : &nbsp;</td>
    <td>{{ $data['ukuran_utara'] }}m</td>
  </tr>
  <tr>
    <td>Sebelah Selatan berbasatan dengan {{ $data['batas_selatan'] }}</td>
    <td>&emsp; : &nbsp;</td>
    <td>{{ $data['ukuran_selatan'] }}m</td>
  </tr>
  <tr>
    <td>Sebelah Barat berbasatan dengan {{ $data['batas_barat'] }}</td>
    <td>&emsp; : &nbsp;</td>
    <td>{{ $data['ukuran_barat'] }}m</td>
  </tr>
  <tr>
    <td>Sebelah Timur berbasatan dengan {{ $data['batas_timur'] }}</td>
    <td>&emsp; : &nbsp;</td>
    <td>{{ $data['ukuran_timur'] }}m</td>
  </tr>
</table>
<p>Selanjutnya <b>PIHAK PERTAMA</b> yang menerima uang ganti kerugian.</p>
<table>
  <tr>
    <td>2.&emsp;</td>
    <td>Nama</td>
    <td>&nbsp; : &nbsp;</td>
    <td><b>{{ Str::upper($data['nama_pihak_kedua']) }}</b></td>
  </tr>
  <tr>
    <td></td>
    <td>Tempat tanggal lahir</td>
    <td>&nbsp; : &nbsp;</td>
    <td>{{ $data['tempat_lahir_pihak_kedua'] }}, {{ \Carbon\Carbon::parse($data['tanggal_lahir_pihak_kedua'])->isoFormat('D MMMM Y') }}</td>
  </tr>
  <tr>
    <td></td>
    <td>Warganegara</td>
    <td>&nbsp; : &nbsp;</td>
    <td>{{ $data['wn_pihak_kedua'] }}</td>
  </tr>
  <tr>
    <td></td>
    <td>No KTP</td>
    <td>&nbsp; : &nbsp;</td>
    <td>{{ $data['ktp_pihak_kedua'] }}</td>
  </tr>
  <tr>
    <td></td>
    <td>Alamat</td>
    <td>&nbsp; : &nbsp;</td>
    <td>{{ $data['alamat_pihak_kedua'] }}</td>
  </tr>
</table>
<p>Selanjutnya <b>PIHAK KEDUA</b> yang membayar uang ganti kerugian.</p>
<p><b>PIHAK PERTAMA</b> menyatakan dengan sesungguhnya dengan akal dan pikiran yang sehat serta tidak dipengaruhi oleh siapapun juga telah menerima uang kontan sebesar
  Rp<b>{{ number_format((int) $data['besaran'], 0, ',', '.') }},- ( {{ $data['terbilang'] }} )</b>.</p>
<p>Sebagai pengganti kerugian atas sebidang tanah seluas &pm; <b>{{ $data['luas_tanah'] }} m&sup2;</b> usaha/garapan <b>PIHAK PERTAMA</b> jumlah tersebut telah
  diterima oleh <b>PIHAK PERTAMA</b> dan surat pernyataan ganti rugi ini berlaku pula sebagai kwitansi tanda penerimaannya serta menyerahkan tanah usaha/garapan
  tersebut dalam keadaan tidak dihuni atau digarap oleh siapapun, oleh <b>PIHAK PERTAMA</b> kepada <b>PIHAK KEDUA</b>.</p>
<p><b>PIHAK PERTAMA</b> menjamin <b>PIHAK KEDUA</b> bahwa <b>PIHAK KEDUA</b> tidak akan mendapat tuntutan dan gugatan apapun dari siapapun serta juga dari Ahli Waris
  <b>PIHAK PERTAMA</b>, dengan ini membebaskan <b>PIHAK KEDUA</b> dari segala tuntutan dan gugatan yang timbul dikemudian hari adalah sepenuhnya menjadi tanggung jawab
  <b>PIHAK PERTAMA</b>.
</p>
<p>&emsp; Dengan Surat Pernyataan Ganti Rugi ini kami buat dengan sebenarnya untuk dapat dipergunakan seperlunya.</p>
<table style="width: 100%">
  <tr>
    <td style="width: 50%"></td>
    <td style="width: 50%; text-align: center;">Air Putih, {{ Carbon\Carbon::parse($data['created_at'])->isoFormat('D MMMM Y') }}</td>
  </tr>
  <tr>
    <td style="width: 50%; text-align: center;"><b>PIHAK KEDUA</b></td>
    <td style="width: 50%; text-align: center;"><b>PIHAK PERTAMA</b></td>
  </tr>
  <tr>
    <td style="width: 50%; text-align: center; padding-top: 3rem"><b>{{ $data['nama_pihak_kedua'] }}</b></td>
    <td style="width: 50%; text-align: center; padding-top: 3rem"><b>{{ $data['nama_pihak_pertama'] }}</b></td>
  </tr>
  <tr>
    <td style="width: 50%; padding-top: 3rem"></td>
    <td style="width: 50%; padding-top: 3rem">Mengetahui</td>
  </tr>
  <tr>
    <td style="width: 50%; padding-top: 1rem"></td>
    <td style="width: 50%; padding-top: 1rem">
      Reg No : {{ $data['no_reg'] }} <br>
      Tanggal : {{ Carbon\Carbon::parse($data['tanggal_reg'])->isoFormat('D MMMM Y') }}
    </td>
  </tr>
  <tr>
    <td style="width: 50%; padding-top: 1rem"></td>
    <td style="width: 50%; padding-top: 1rem">Kepala Desa Air Putih</td>
  </tr>
  <tr>
    <td style="width: 50%; padding-top: 3rem"></td>
    <td style="width: 50%; padding-top: 3rem"><b>{{ $data['mengetahui'] }}</b></td>
  </tr>
</table>
