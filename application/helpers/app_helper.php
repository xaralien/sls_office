<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
function tgl_indo($tanggal)
{
  $bulan = array(
    1 =>   'Januari',
    'Februari',
    'Maret',
    'April',
    'Mei',
    'Juni',
    'Juli',
    'Agustus',
    'September',
    'Oktober',
    'November',
    'Desember'
  );
  $pecahkan = explode('-', $tanggal);

  // variabel pecahkan 0 = tanggal
  // variabel pecahkan 1 = bulan
  // variabel pecahkan 2 = tahun

  return $pecahkan[2] . ' ' . $bulan[(int)$pecahkan[1]] . ' ' . $pecahkan[0];
}

// function terbilang($angka)
// {
//   $angka = floatval($angka);
//   $bilangan = [
//     '',
//     'Satu',
//     'Dua',
//     'Tiga',
//     'Empat',
//     'Lima',
//     'Enam',
//     'Tujuh',
//     'Delapan',
//     'Sembilan',
//     'Sepuluh',
//     'Sebelas'
//   ];

//   if ($angka < 12) {
//     return $bilangan[$angka];
//   } else if ($angka < 20) {
//     return $bilangan[$angka - 10] . ' Belas';
//   } else if ($angka < 100) {
//     return $bilangan[floor($angka / 10)] . ' Puluh ' . $bilangan[$angka % 10];
//   } else if ($angka < 200) {
//     return 'Seratus ' . terbilang($angka - 100);
//   } else if ($angka < 1000) {
//     return $bilangan[floor($angka / 100)] . ' Ratus ' . terbilang($angka % 100);
//   } else if ($angka < 2000) {
//     return 'Seribu ' . terbilang($angka - 1000);
//   } else if ($angka < 1000000) {
//     return terbilang(floor($angka / 1000)) . ' Ribu ' . terbilang($angka % 1000);
//   } else if ($angka < 1000000000) {
//     return terbilang(floor($angka / 1000000)) . ' Juta ' . terbilang($angka % 1000000);
//   } else {
//     return 'Angka terlalu besar';
//   }
// }
