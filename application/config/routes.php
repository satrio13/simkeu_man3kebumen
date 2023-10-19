<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
$route = array(
    'default_controller' => 'backend',
    'backend/tahun' => 'tahun', // start tahun
    'backend/tambah-tahun' => 'tahun/tambah-tahun',
    'backend/edit-tahun/(:num)' => 'tahun/edit-tahun/$1',
    'backend/hapus-tahun/(:num)' => 'tahun/hapus-tahun/$1', // end tahun
    'backend/jenis-tagihan' => 'jenis-tagihan', // start jenis tagihan
    'backend/tambah-jenis-tagihan' => 'jenis-tagihan/tambah-jenis-tagihan',
    'backend/edit-jenis-tagihan/(:num)' => 'jenis-tagihan/edit-jenis-tagihan/$1',
    'backend/hapus-jenis-tagihan/(:num)' => 'jenis-tagihan/hapus-jenis-tagihan/$1', // end jenis tagihan
    'backend/tagihan' => 'tagihan', // start tagihan
    'backend/tambah-tagihan' => 'tagihan/tambah-tagihan', 
    'backend/edit-tagihan/(:num)' => 'tagihan/edit-tagihan/$1',
    'backend/hapus-tagihan/(:num)' => 'tagihan/hapus-tagihan/$1', // end tagihan
    'backend/jurusan' => 'jurusan', // start jurusan
    'backend/tambah-jurusan' => 'jurusan/tambah-jurusan',
    'backend/edit-jurusan/(:num)' => 'jurusan/edit-jurusan/$1',
    'backend/hapus-jurusan/(:num)' => 'jurusan/hapus-jurusan/$1', // end jurusan
    'backend/kelas' => 'kelas', // start kelas
    'backend/get_data_kelas' => 'kelas/get_data_kelas',
    'backend/tambah-kelas' => 'kelas/tambah-kelas',
    'backend/edit-kelas/(:num)' => 'kelas/edit-kelas/$1',
    'backend/hapus-kelas/(:num)' => 'kelas/hapus-kelas/$1', // end kelas
    'backend/guru' => 'guru', // start guru
    'backend/get_data_guru' => 'guru/get_data_guru',
    'backend/tambah-guru' => 'guru/tambah-guru',
    'backend/cek-guru-batch' => 'guru/cek-guru-batch',
    'backend/guru-batch/(:num)' => 'guru/guru-batch/$1',
    'backend/form-guru' => 'guru/form-guru',
    'backend/import-guru' => 'guru/import-guru',
    'backend/edit-guru/(:num)' => 'guru/edit-guru/$1',
    'backend/hapus-guru/(:num)' => 'guru/hapus-guru/$1', // end guru
    'backend/kelas-wali' => 'kelas-wali', // start kelas wali
    'backend/get_data_kelas_wali' => 'kelas-wali/get_data_kelas_wali',
    'backend/tambah-kelas-wali' => 'kelas-wali/tambah-kelas-wali',
    'backend/edit-kelas-wali/(:num)' => 'kelas-wali/edit-kelas-wali/$1',
    'backend/hapus-kelas-wali/(:num)' => 'kelas-wali/hapus-kelas-wali/$1', // end kelas wali
    'backend/siswa' => 'siswa', // start siswa
    'backend/get_data_siswa' => 'siswa/get_data_siswa',
    'backend/tambah-siswa' => 'siswa/tambah-siswa',
    'backend/cek-siswa-batch' => 'siswa/cek-siswa-batch',
    'backend/siswa-batch/(:num)' => 'siswa/siswa-batch/$1',
    'backend/form-siswa' => 'siswa/form-siswa',
    'backend/import-siswa' => 'siswa/import-siswa',
    'backend/edit-siswa/(:num)' => 'siswa/edit-siswa/$1',
    'backend/hapus-siswa/(:num)' => 'siswa/hapus-siswa/$1', // end siswa
    'backend/transaksi-semester' => 'transaksi-semester', // start transaksi semester
    'backend/get_data_transaksi_semester' => 'transaksi-semester/get_data_transaksi_semester',
    'backend/hapus-transaksi-semester/(:num)' => 'transaksi-semester/hapus-transaksi-semester/$1',
    'backend/trans-semester' => 'transaksi-semester/trans-semester', // end transaksi semester
    'backend/setting-bsm' => 'setting-bsm', // start setting bsm
    'backend/update-bsm' => 'setting-bsm/update-bsm',
    'backend/tagihan-tahunan' => 'tagihan-tahunan', // start tagihan tahunan
    'backend/get_data_tagihan_tahunan' => 'tagihan-tahunan/get_data_tagihan_tahunan',
    'backend/cek_tagihan' => 'tagihan-tahunan/cek_tagihan',
    'backend/tambah-tagihan-tahunan' => 'tagihan-tahunan/tambah-tagihan-tahunan',
    'backend/edit-tagihan-tahunan/(:num)' => 'tagihan-tahunan/edit-tagihan-tahunan/$1',
    'backend/hapus-tagihan-tahunan/(:num)' => 'tagihan-tahunan/hapus-tagihan-tahunan/$1', // end tagihan tahunan
    'backend/pembayaran' => 'pembayaran', // start pembayaran
    'backend/get_data_pembayaran' => 'pembayaran/get_data_pembayaran', 
    'backend/bayar/(:num)' => 'pembayaran/bayar/$1',
    'backend/riwayat/(:num)' => 'pembayaran/riwayat/$1',
    'backend/cetak-riwayat/(:num)' => 'pembayaran/cetak-riwayat/$1',
    'backend/cetak-riwayat-pdf/(:num)' => 'pembayaran/cetak-riwayat-pdf/$1',
    'backend/cetak-slip/(:num)' => 'pembayaran/cetak-slip/$1',
    'backend/cetak-slip-pdf/(:num)' => 'pembayaran/cetak-slip-pdf/$1',
    'backend/hapus-pembayaran/(:num)' => 'pembayaran/hapus-pembayaran/$1', // end pembayaran
    'backend/tabungan' => 'tabungan', // start tabungan
    'backend/get_data_tabungan' => 'tabungan/get_data_tabungan', 
    'backend/nabung/(:num)' => 'tabungan/nabung/$1',
    'backend/riwayat-tabungan/(:num)' => 'tabungan/riwayat-tabungan/$1',
    'backend/cetak-riwayat-tabungan/(:num)' => 'tabungan/cetak-riwayat-tabungan/$1',
    'backend/cetak-riwayat-tabungan-pdf/(:num)' => 'tabungan/cetak-riwayat-tabungan-pdf/$1',
    'backend/cetak-slip-tabungan/(:num)' => 'tabungan/cetak-slip-tabungan/$1',
    'backend/cetak-slip-tabungan-pdf/(:num)' => 'tabungan/cetak-slip-tabungan-pdf/$1',
    'backend/hapus-tabungan/(:num)' => 'tabungan/hapus-tabungan/$1',
    'backend/hapus-tabungan/(:num)/(:num)' => 'tabungan/hapus-tabungan/$1/$2', // end tabungan
    'backend/laporan-riwayat' => 'laporan/laporan-riwayat', //start laporan riwayat
    'backend/cetak-laporan-riwayat-pdf/(:any)/(:any)/(:any)/(:any)/(:any)' => 'laporan/cetak-laporan-riwayat-pdf/$1/$2/$3/$4/$5',
    'backend/cetak-laporan-riwayat/(:any)/(:any)/(:any)/(:any)/(:any)' => 'laporan/cetak-laporan-riwayat/$1/$2/$3/$4/$5', 
    'backend/cetak-laporan-riwayat-excel/(:any)/(:any)/(:any)/(:any)/(:any)' => 'laporan/cetak-laporan-riwayat-excel/$1/$2/$3/$4/$5', //end laporan riwayat
    'backend/laporan-persiswa' => 'laporan/laporan-persiswa', //start laporan persiswa
    'backend/cetak-laporan-persiswa-pdf/(:any)' => 'laporan/cetak-laporan-persiswa-pdf/$1',
    'backend/cetak-laporan-persiswa/(:any)' => 'laporan/cetak-laporan-persiswa/$1', //end laporan persiswa
    'backend/laporan-kekurangan' => 'laporan/laporan-kekurangan', //start laporan kekurangan per tagihan
    'backend/cetak-laporan-kekurangan-pdf/(:any)/(:any)/(:any)' => 'laporan/cetak-laporan-kekurangan-pdf/$1/$2/$3',
    'backend/cetak-laporan-kekurangan-excel/(:any)/(:any)/(:any)' => 'laporan/cetak-laporan-kekurangan-excel/$1/$2/$3',
    'backend/cetak-laporan-kekurangan/(:any)/(:any)/(:any)' => 'laporan/cetak-laporan-kekurangan/$1/$2/$3', //end laporan kekurangan per tagihan
    'backend/laporan-semua-kekurangan' => 'laporan/laporan-semua-kekurangan', //start laporan semua kekurangan
    'backend/cetak-laporan-semua-kekurangan-pdf/(:any)/(:any)' => 'laporan/cetak-laporan-semua-kekurangan-pdf/$1/$2',
    'backend/cetak-laporan-semua-kekurangan-excel/(:any)/(:any)' => 'laporan/cetak-laporan-semua-kekurangan-excel/$1/$2',
    'backend/cetak-laporan-semua-kekurangan/(:any)/(:any)' => 'laporan/cetak-laporan-semua-kekurangan/$1/$2', //end laporan semua kekurangan
    'backend/users' => 'user', //start user
    'backend/tambah-user' => 'user/tambah-user',
    'backend/edit-user/(:any)' => 'user/edit-user/$1',
    'backend/hapus-user/(:any)' => 'user/hapus-user/$1',
    'backend/edit-profil' => 'user/edit-profil',
    'backend/ganti-password' => 'user/ganti-password', 
    'backend/ttd/(:num)' => 'user/ttd/$1', //end user
    'backend/backup' => 'backup'
);
$route['404_override'] = '';
$route['translate_uri_dashes'] = TRUE;
